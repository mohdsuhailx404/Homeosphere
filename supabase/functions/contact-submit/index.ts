import "jsr:@supabase/functions-js/edge-runtime.d.ts";

const corsHeaders = {
  "Access-Control-Allow-Origin": "*",
  "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, OPTIONS",
  "Access-Control-Allow-Headers":
    "Content-Type, Authorization, X-Client-Info, Apikey",
};

const SUPABASE_URL = Deno.env.get("SUPABASE_URL")!;
const SERVICE_ROLE_KEY = Deno.env.get("SUPABASE_SERVICE_ROLE_KEY")!;

Deno.serve(async (req: Request) => {
  if (req.method === "OPTIONS") {
    return new Response(null, { status: 200, headers: corsHeaders });
  }

  if (req.method !== "POST") {
    return new Response(
      JSON.stringify({ success: false, error: "Method not allowed" }),
      { status: 405, headers: { ...corsHeaders, "Content-Type": "application/json" } },
    );
  }

  try {
    const data = await req.json();

    const name = String(data?.name ?? "").trim();
    const email = String(data?.email ?? "").trim();
    const phone = String(data?.phone ?? "").trim();
    const requirement = String(data?.requirement ?? "").trim();
    const message = String(data?.message ?? "").trim();

    const errors: string[] = [];
    if (!name) errors.push("name is required");
    if (!email) errors.push("email is required");
    else if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email))
      errors.push("a valid email is required");
    if (!requirement) errors.push("requirement is required");
    if (!message) errors.push("message is required");

    if (errors.length) {
      return new Response(
        JSON.stringify({
          success: false,
          error: "Please fix: " + errors.join(", "),
        }),
        {
          status: 422,
          headers: { ...corsHeaders, "Content-Type": "application/json" },
        },
      );
    }

    const payload = {
      name: name.slice(0, 120),
      email: email.slice(0, 200),
      phone: phone ? phone.slice(0, 30) : null,
      requirement: requirement.slice(0, 80),
      message: message.slice(0, 4000),
    };

    const res = await fetch(
      `${SUPABASE_URL}/rest/v1/contact_submissions`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          apikey: SERVICE_ROLE_KEY,
          Authorization: `Bearer ${SERVICE_ROLE_KEY}`,
          Prefer: "return=representation",
        },
        body: JSON.stringify(payload),
      },
    );

    if (!res.ok) {
      const body = await res.text();
      return new Response(
        JSON.stringify({
          success: false,
          error: "The database rejected the submission.",
          detail: body,
        }),
        {
          status: 502,
          headers: { ...corsHeaders, "Content-Type": "application/json" },
        },
      );
    }

    return new Response(
      JSON.stringify({
        success: true,
        message: "Your message has been received.",
      }),
      { status: 200, headers: { ...corsHeaders, "Content-Type": "application/json" } },
    );
  } catch (err) {
    return new Response(
      JSON.stringify({ success: false, error: String(err) }),
      { status: 500, headers: { ...corsHeaders, "Content-Type": "application/json" } },
    );
  }
});
