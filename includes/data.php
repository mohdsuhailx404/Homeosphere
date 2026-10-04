<?php
/**
 * Centralised mock data for the Homeosphere platform.
 * Mirrors the React version's src/data.js — same content, same Pexels imagery.
 */

function px($id, $w = 800) {
  return "https://picsum.photos/seed/$id/$w/600";
}

function cities(): array {
  return ['Mumbai','Delhi NCR','Bengaluru','Hyderabad','Pune','Chennai','Kolkata','Ahmedabad','Jaipur','Lucknow','Gurugram','Noida'];
}

function property_types(): array {
  return ['Apartment','Villa','Independent House','Plot','Penthouse','Studio'];
}

function furnishing_types(): array {
  return ['Fully Furnished','Semi Furnished','Unfurnished'];
}

function amenities_list(): array {
  return ['Pool','Gym','Parking','Power Backup','Security','Garden','Clubhouse','Lift','Kids Play','CCTV'];
}

function properties(): array {
  return [
    ['id'=>'p1','title'=>'3BHK Luxury Apartment with Skyline View','type'=>'Apartment','listing'=>'Buy',
     'price'=>18500000,'priceLabel'=>'₹1.85 Cr','location'=>'Worli, Mumbai','city'=>'Mumbai',
     'beds'=>3,'baths'=>3,'area'=>1450,'furnishing'=>'Semi Furnished',
     'amenities'=>['Pool','Gym','Parking','Security','Lift','Clubhouse'],
     'image'=>'/assets/img/properties/prop_mumbai.jpg','verified'=>true,'rating'=>4.8,'tag'=>'Premium',
     'lat'=>19.0178,'lng'=>72.8178,'coords'=>['x'=>30,'y'=>45]],
    ['id'=>'p2','title'=>'Spacious 2BHK in Tech Corridor','type'=>'Apartment','listing'=>'Rent',
     'price'=>38000,'priceLabel'=>'₹38k/mo','location'=>'Whitefield, Bengaluru','city'=>'Bengaluru',
     'beds'=>2,'baths'=>2,'area'=>1180,'furnishing'=>'Fully Furnished',
     'amenities'=>['Gym','Parking','Power Backup','Security','Garden'],
     'image'=>'/assets/img/properties/prop_blr.jpg','verified'=>true,'rating'=>4.6,'tag'=>'Hot Deal',
     'lat'=>12.9698,'lng'=>77.7500,'coords'=>['x'=>55,'y'=>70]],
    ['id'=>'p3','title'=>'Independent Villa with Private Garden','type'=>'Villa','listing'=>'Buy',
     'price'=>42000000,'priceLabel'=>'₹4.20 Cr','location'=>'Banjara Hills, Hyderabad','city'=>'Hyderabad',
     'beds'=>4,'baths'=>5,'area'=>3200,'furnishing'=>'Semi Furnished',
     'amenities'=>['Pool','Garden','Parking','Security','CCTV'],
     'image'=>'/assets/img/properties/prop_hyd.jpg','verified'=>true,'rating'=>4.9,'tag'=>'Luxury',
     'lat'=>17.4156,'lng'=>78.4354,'coords'=>['x'=>48,'y'=>62]],
    ['id'=>'p4','title'=>'Modern 1BHK Studio for Young Pros','type'=>'Studio','listing'=>'Rent',
     'price'=>22000,'priceLabel'=>'₹22k/mo','location'=>'Sector 62, Noida','city'=>'Noida',
     'beds'=>1,'baths'=>1,'area'=>540,'furnishing'=>'Fully Furnished',
     'amenities'=>['Gym','Parking','Security','Lift'],
     'image'=>'/assets/img/properties/prop_noida.webp','verified'=>true,'rating'=>4.4,'tag'=>'Budget',
     'lat'=>28.6258,'lng'=>77.3653,'coords'=>['x'=>68,'y'=>40]],
    ['id'=>'p5','title'=>'Premium Penthouse with Terrace','type'=>'Penthouse','listing'=>'Buy',
     'price'=>65000000,'priceLabel'=>'₹6.50 Cr','location'=>'Golf Course Road, Gurugram','city'=>'Gurugram',
     'beds'=>4,'baths'=>4,'area'=>2800,'furnishing'=>'Fully Furnished',
     'amenities'=>['Pool','Gym','Parking','Security','Clubhouse','Garden'],
     'image'=>'/assets/img/properties/prop_ggm.jpg','verified'=>true,'rating'=>4.9,'tag'=>'Luxury',
     'lat'=>28.4595,'lng'=>77.0984,'coords'=>['x'=>70,'y'=>35]],
    ['id'=>'p6','title'=>'Family 3BHK Near Top Schools','type'=>'Apartment','listing'=>'Buy',
     'price'=>9800000,'priceLabel'=>'₹98 L','location'=>'Baner, Pune','city'=>'Pune',
     'beds'=>3,'baths'=>2,'area'=>1320,'furnishing'=>'Semi Furnished',
     'amenities'=>['Gym','Parking','Security','Kids Play','Garden'],
     'image'=>'/assets/img/properties/prop_pune.webp','verified'=>true,'rating'=>4.7,'tag'=>'Family',
     'lat'=>18.5590,'lng'=>73.7868,'coords'=>['x'=>42,'y'=>68]],
    ['id'=>'p7','title'=>'Cozy 2BHK in Quiet Neighbourhood','type'=>'Apartment','listing'=>'Rent',
     'price'=>28000,'priceLabel'=>'₹28k/mo','location'=>'Indiranagar, Bengaluru','city'=>'Bengaluru',
     'beds'=>2,'baths'=>2,'area'=>1040,'furnishing'=>'Semi Furnished',
     'amenities'=>['Parking','Security','Garden','Lift'],
     'image'=>'/assets/img/properties/prop_blr_indiranagar.jpg','verified'=>false,'rating'=>4.3,'tag'=>'',
     'lat'=>12.9784,'lng'=>77.6408,'coords'=>['x'=>56,'y'=>72]],
    ['id'=>'p8','title'=>'Independent House with Large Lawn','type'=>'Independent House','listing'=>'Buy',
     'price'=>31000000,'priceLabel'=>'₹3.10 Cr','location'=>'Vaishali Nagar, Jaipur','city'=>'Jaipur',
     'beds'=>4,'baths'=>3,'area'=>2400,'furnishing'=>'Unfurnished',
     'amenities'=>['Garden','Parking','Power Backup','CCTV'],
     'image'=>'/assets/img/properties/prop_jaipur.jpg','verified'=>true,'rating'=>4.5,'tag'=>'',
     'lat'=>26.9075,'lng'=>75.7428,'coords'=>['x'=>38,'y'=>50]],
  ];
}

function service_categories(): array {
  return [
    ['id'=>'cleaning','name'=>'Home Cleaning','icon'=>'sparkles','start'=>299,'rating'=>4.8,'image'=>'/assets/img/service/cleaning.jpg'],
    ['id'=>'ac','name'=>'AC Repair','icon'=>'wind','start'=>499,'rating'=>4.7,'image'=>'/assets/img/service/ac_repair.jpg'],
    ['id'=>'electric','name'=>'Electrical Services','icon'=>'zap','start'=>199,'rating'=>4.8,'image'=>'/assets/img/service/electrical_services.jpg'],
    ['id'=>'plumbing','name'=>'Plumbing','icon'=>'droplets','start'=>199,'rating'=>4.6,'image'=>'/assets/img/service/plumbing.jpg'],
    ['id'=>'painting','name'=>'Painting','icon'=>'paintbrush','start'=>12,'rating'=>4.7,'image'=>'/assets/img/service/painting.webp'],
    ['id'=>'pest','name'=>'Pest Control','icon'=>'bug','start'=>699,'rating'=>4.5,'image'=>'/assets/img/service/pest_control.jpg'],
    ['id'=>'carpentry','name'=>'Carpentry','icon'=>'hammer','start'=>249,'rating'=>4.6,'image'=>'/assets/img/service/carpentry.jpg'],
    ['id'=>'appliance','name'=>'Appliance Repair','icon'=>'washing','start'=>299,'rating'=>4.7,'image'=>'/assets/img/service/appliance_repair.jpg'],
    ['id'=>'interior','name'=>'Interior Design','icon'=>'sofa','start'=>49999,'rating'=>4.9,'image'=>'/assets/img/service/interior_design.jpg'],
    ['id'=>'renovation','name'=>'Renovation Services','icon'=>'hardhat','start'=>99999,'rating'=>4.8,'image'=>'/assets/img/service/renovation_services.jpg'],
    ['id'=>'moving','name'=>'Moving Services','icon'=>'truck','start'=>2999,'rating'=>4.5,'image'=>'/assets/img/service/moving_services.jpg'],
    ['id'=>'security','name'=>'Security Services','icon'=>'shield','start'=>1499,'rating'=>4.7,'image'=>'/assets/img/service/security_services.jpg'],
  ];
}

function professionals(): array {
  return [
    ['id'=>'pr1','name'=>'Arjun Mehta','role'=>'Architect',
     'avatar'=>'/assets/img/Professional Portfolios/Arjun Mehta Architect/avatar.png',
     'img'=>'/assets/img/Professional Portfolios/Arjun Mehta Architect/avatar.png',
     'skills'=>['Residential Design','Sustainable Architecture','3D Planning'],
     'experience'=>12,'location'=>'Mumbai, MH','rating'=>4.9,'reviews'=>214,
     'portfolio'=>[
       '/assets/img/Professional Portfolios/Arjun Mehta Architect/portfolio1.jpg',
       '/assets/img/Professional Portfolios/Arjun Mehta Architect/portfolio2.jpg',
       '/assets/img/Professional Portfolios/Arjun Mehta Architect/portfolio3.jpg',
     ],'verified'=>true,'projects'=>86],
    ['id'=>'pr2','name'=>'Priya Sharma','role'=>'Interior Designer',
     'avatar'=>'/assets/img/Professional Portfolios/Priya Sharma Interior Designer/avatar.png',
     'img'=>'/assets/img/Professional Portfolios/Priya Sharma Interior Designer/avatar.png',
     'skills'=>['Modular Kitchens','Space Planning','Lighting Design'],
     'experience'=>9,'location'=>'Bengaluru, KA','rating'=>4.8,'reviews'=>176,
     'portfolio'=>[
       '/assets/img/Professional Portfolios/Priya Sharma Interior Designer/portfolio1.jpg',
       '/assets/img/Professional Portfolios/Priya Sharma Interior Designer/portfolio2.png',
       '/assets/img/Professional Portfolios/Priya Sharma Interior Designer/portfolio3.jpg',
     ],'verified'=>true,'projects'=>64],
    ['id'=>'pr3','name'=>'Rajesh Kumar','role'=>'Contractor',
     'avatar'=>'/assets/img/Professional Portfolios/Rajesh Kumar Contractor/avatar.png',
     'img'=>'/assets/img/Professional Portfolios/Rajesh Kumar Contractor/avatar.png',
     'skills'=>['Civil Work','Turnkey Projects','Renovation'],
     'experience'=>18,'location'=>'Delhi NCR, DL','rating'=>4.7,'reviews'=>308,
     'portfolio'=>[
       '/assets/img/Professional Portfolios/Rajesh Kumar Contractor/portfolio1.jpg',
       '/assets/img/Professional Portfolios/Rajesh Kumar Contractor/portfolio2.jpg',
       '/assets/img/Professional Portfolios/Rajesh Kumar Contractor/portfolio3.jpg',
     ],'verified'=>true,'projects'=>142],
    ['id'=>'pr4','name'=>'Sunita Devi','role'=>'Electrician',
     'avatar'=>'/assets/img/Professional Portfolios/Sunita Devi Electrician/avatar.png',
     'img'=>'/assets/img/Professional Portfolios/Sunita Devi Electrician/avatar.png',
     'skills'=>['Wiring','Switchboard','Inverter Setup'],
     'experience'=>8,'location'=>'Pune, MH','rating'=>4.6,'reviews'=>142,
     'portfolio'=>[
       '/assets/img/Professional Portfolios/Sunita Devi Electrician/portfolio1.jpg',
       '/assets/img/Professional Portfolios/Sunita Devi Electrician/portfolio2.webp',
       '/assets/img/Professional Portfolios/Sunita Devi Electrician/portfolio3.jpg',
     ],'verified'=>true,'projects'=>540],
    ['id'=>'pr5','name'=>'Mohammed Irfan','role'=>'Plumber',
     'avatar'=>'/assets/img/Professional Portfolios/Mohammed Irfan Plumber/avatar.png',
     'img'=>'/assets/img/Professional Portfolios/Mohammed Irfan Plumber/avatar.png',
     'skills'=>['Leakage Repair','Bathroom Fitting','Pipe Installation'],
     'experience'=>11,'location'=>'Hyderabad, TS','rating'=>4.8,'reviews'=>198,
     'portfolio'=>[
       '/assets/img/Professional Portfolios/Mohammed Irfan Plumber/portfolio1.jpg',
       '/assets/img/Professional Portfolios/Mohammed Irfan Plumber/portfolio2.jpg',
       '/assets/img/Professional Portfolios/Mohammed Irfan Plumber/portfolio3.webp',
     ],'verified'=>true,'projects'=>620],
    ['id'=>'pr6','name'=>'Anjali Verma','role'=>'Painter',
     'avatar'=>'/assets/img/Professional Portfolios/Anjali Verma Painter/avatar.png',
     'img'=>'/assets/img/Professional Portfolios/Anjali Verma Painter/avatar.png',
     'skills'=>['Texture Paint','Waterproofing','Wall Stencils'],
     'experience'=>7,'location'=>'Jaipur, RJ','rating'=>4.5,'reviews'=>96,
     'portfolio'=>[
       '/assets/img/Professional Portfolios/Anjali Verma Painter/portfolio1.jpg',
       '/assets/img/Professional Portfolios/Anjali Verma Painter/portfolio2.jpg',
       '/assets/img/Professional Portfolios/Anjali Verma Painter/portfolio3.webp',
     ],'verified'=>true,'projects'=>210],
  ];
}

function blog_posts(): array {
  return [
    [
      'id'          => 'b1',
      'slug'        => 'real-estate-trends-2026',
      'title'       => 'Real Estate Trends 2026: Where Indian Property Is Headed',
      'category'    => 'Real Estate Trends',
      'read'        => '8 min',
      'author'      => 'Editorial Team',
      'date'        => '2026-07-20',
      'image'       => '/assets/img/blog_cover_images/Real_Estate_Trends_2026_Where_Indian_Property _Is_Headed.png',
      'excerpt'     => 'Tier-2 cities, smart homes, and fractional ownership — three forces reshaping Indian real estate this year.',
      'quote'       => '2026 mein property sirf ek investment nahi, ek smart decision hai — right location, right home aur right future ke saath.',
      'source'      => 'medium',
      'source_name' => 'Medium',
      'source_url'  => 'https://medium.com/@deeksha_48830/real-estate-trends-2026-where-indian-property-is-headed-fd351a197e0d?postPublishedType=initial',
      'featured'    => true,
    ],
    [
      'id'          => 'b2',
      'slug'        => 'first-home-buyers-guide',
      'title'       => 'The Complete First-Time Home Buyer Guide for India',
      'category'    => 'Home Buying Guides',
      'read'        => '12 min',
      'author'      => 'Homeosphere Editorial',
      'date'        => '2026-07-17',
      'image'       => '/assets/img/blog_cover_images/The Complete First-Time Home Buyer Guide for India.png',
      'excerpt'     => 'From budgeting and home loans to legal checks and registration — everything you need before signing the deed.',
      'quote'       => 'Ghar ka sapna bada rakho, bas uski EMI ko sapne se bada mat hone do.',
      'source'      => 'substack',
      'source_name' => 'Substack',
      'source_url'  => 'https://homeosphere.substack.com/p/the-complete-first-time-home-buyer',
      'featured'    => false,
    ],
    [
      'id'          => 'b3',
      'slug'        => 'property-investment-hotspots',
      'title'       => '7 Property Investment Hotspots Beyond the Metro Cities',
      'category'    => 'Property Investment',
      'read'        => '9 min',
      'author'      => 'Homeosphere Research',
      'date'        => '2026-07-14',
      'image'       => '/assets/img/blog_cover_images/7 Property Investment Hotspots Beyond the Metro Cities.jpg',
      'excerpt'     => 'High-yield micro-markets where entry prices are still reasonable and rental demand is climbing.',
      'quote'       => 'Property ki chaar deewarein nahi, uske aas-paas ka shehar bhi aapka future decide karta hai.',
      'source'      => 'devto',
      'source_name' => 'DEV Community',
      'source_url'  => 'https://dev.to/homeosphere01/7-property-investment-hotspots-beyond-the-metro-cities-295k',
      'featured'    => false,
    ],
    [
      'id'          => 'b4',
      'slug'        => 'seasonal-home-maintenance',
      'title'       => 'Seasonal Home Maintenance Checklist Every Owner Needs',
      'category'    => 'Home Maintenance Tips',
      'read'        => '7 min',
      'author'      => 'Homeosphere Operations',
      'date'        => '2026-07-11',
      'image'       => '/assets/img/blog_cover_images/Seasonal Home Maintenance Checklist Every Owner Needs.png',
      'excerpt'     => 'Monsoon, summer, and winter — the upkeep tasks that protect your home and your investment year-round.',
      'quote'       => 'Har season ka apna asar, timely maintenance rakhe ghar behtar.',
      'source'      => 'devto',
      'source_name' => 'DEV Community',
      'source_url'  => 'https://dev.to/homeosphere01/7-property-investment-hotspots-beyond-the-metro-cities-295k',
      'featured'    => false,
    ],
    [
      'id'          => 'b5',
      'slug'        => 'small-space-interior-ideas',
      'title'       => '10 Interior Design Ideas That Make Small Homes Feel Huge',
      'category'    => 'Interior Design Ideas',
      'read'        => '6 min',
      'author'      => 'Homeosphere Design Desk',
      'date'        => '2026-07-08',
      'image'       => '/assets/img/blog_cover_images/10 Interior Design Ideas That Make Small Homes Feel Huge.webp',
      'excerpt'     => 'Clever storage, mirror tricks, and multi-functional furniture that transform compact apartments.',
      'quote'       => 'Chhota ghar bhi shaandar lag sakta hai jab har inch ko samajhdaari se design kiya jaye.',
      'source'      => 'tumblr',
      'source_name' => 'Tumblr',
      'source_url'  => 'https://www.tumblr.com/blog/homeosphere',
      'featured'    => false,
    ],
    [
      'id'          => 'b6',
      'slug'        => 'smart-home-essentials',
      'title'       => 'Smart Home Essentials: Build a Connected Home on Any Budget',
      'category'    => 'Smart Homes',
      'read'        => '10 min',
      'author'      => 'PropTech Desk',
      'date'        => '2026-07-05',
      'image'       => '/assets/img/blog_cover_images/Smart Home Essentials Build a Connected Home on Any Budget.jpg',
      'excerpt'     => 'From smart lights to security cameras — the devices that actually add value (and the ones that do not).',
      'quote'       => 'Smart home woh nahi jo sirf dikhne mein futuristic lage, balki woh jo aapki rozmarra zindagi ko aasan banaye.',
      'source'      => 'twitter',
      'source_name' => 'X (Twitter)',
      'source_url'  => 'https://x.com/homeosphere',
      'featured'    => false,
    ],
    [
      'id'          => 'b7',
      'slug'        => 'rental-agreement-checklist',
      'title'       => 'Rental Agreement Checklist: What Tenants Must Verify',
      'category'    => 'Rental Advice',
      'read'        => '5 min',
      'author'      => 'Legal & Compliance Team',
      'date'        => '2026-07-02',
      'image'       => '/assets/img/blog_cover_images/Rental Agreement Checklist What Tenants Must Verify.jpg',
      'excerpt'     => 'The clauses, deposits, and legal safeguards every tenant should understand before moving in.',
      'quote'       => 'Sign karne se pehle har clause padhna zaroori hai — ek galat line saalon ki pareshani ban sakti hai.',
      'source'      => 'internal',
      'source_name' => 'Homeosphere Legal',
      'source_url'  => '',
      'featured'    => false,
    ],
  ];
}

function testimonials(): array {
  return [
    ['id'=>'t1','name'=>'Rohan & Meera','role'=>'Home Buyers, Pune','avatar'=>'/assets/img/Testimonial Avatars/Rohan & Meera (Home Buyers, Pune).jpg','rating'=>5,
     'text'=>'We found our dream 3BHK on Homeosphere in two weeks. The verified badge gave us confidence, and the neighbourhood insights were spot on.'],
    ['id'=>'t2','name'=>'Vikram Reddy','role'=>'Property Owner, Hyderabad','avatar'=>'/assets/img/Testimonial Avatars/Vikram Reddy (Property Owner, Hyderabad).jpeg','rating'=>5,
     'text'=>'Managing three rental properties used to be a nightmare. The property management dashboard tracks rent, maintenance, and tenants in one place. Game changer.'],
    ['id'=>'t3','name'=>'Aisha Khan','role'=>'Tenant, Bengaluru','avatar'=>'/assets/img/Testimonial Avatars/Aisha Khan (Tenant, Bengaluru).jpg','rating'=>5,
     'text'=>'Raising a maintenance request and getting a verified plumber the same day — this is how renting should feel. Transparent and stress-free.'],
    ['id'=>'t4','name'=>'Sanjay Gupta','role'=>'Service Professional, Delhi','avatar'=>'/assets/img/Testimonial Avatars/Sanjay Gupta (Service Professional, Delhi).jpg','rating'=>5,
     'text'=>'As an electrician, Homeosphere filled my calendar in the first month. Background verification built trust, and payments are always on time.'],
  ];
}

function stats(): array {
  return [
    ['value'=>'10,000+','label'=>'Properties Listed'],
    ['value'=>'5,000+','label'=>'Verified Professionals'],
    ['value'=>'50+','label'=>'Cities Covered'],
    ['value'=>'24/7','label'=>'Customer Support'],
  ];
}

function lifestyle_suggestions(): array {
  return [
    ['id'=>'family','title'=>'Family Home','desc'=>'Near schools, parks, and safe neighbourhoods','icon'=>'home','img'=>'/assets/img/Lifestyle Cards on Homepage/Family Home card.png'],
    ['id'=>'investment','title'=>'Investment Property','desc'=>'High rental yield in growth corridors','icon'=>'trending','img'=>'/assets/img/Lifestyle Cards on Homepage/Investment Property card.jpg'],
    ['id'=>'luxury','title'=>'Luxury Living','desc'=>'Premium homes with world-class amenities','icon'=>'crown','img'=>'/assets/img/Lifestyle Cards on Homepage/Luxury Living card.jpg'],
    ['id'=>'budget','title'=>'Budget Friendly','desc'=>'Quality homes within your first budget','icon'=>'wallet','img'=>'/assets/img/Lifestyle Cards on Homepage/Budget Friendly card.jpg'],
  ];
}

function trust_features(): array {
  return [
    ['icon'=>'badge','title'=>'Verified Listings','desc'=>'Every property is checked before it goes live.'],
    ['icon'=>'shield','title'=>'Background-Checked Pros','desc'=>'Professionals are ID and skill verified.'],
    ['icon'=>'lock','title'=>'Secure Payments','desc'=>'Bank-grade encryption on every transaction.'],
    ['icon'=>'headset','title'=>'24/7 Support','desc'=>'Real humans, any time you need help.'],
  ];
}

function user_roles(): array {
  return [
    ['id'=>'buyer','role'=>'Buyer','icon'=>'search','color'=>'navy',
     'features'=>['Search properties with smart filters','Compare up to 3 properties side by side','Schedule visits with one tap','Contact verified sellers directly']],
    ['id'=>'seller','role'=>'Seller','icon'=>'tag','color'=>'gold',
     'features'=>['List a property in under 5 minutes','Manage all inquiries from one inbox','Track leads and view interest trends','Get a free property valuation estimate']],
    ['id'=>'tenant','role'=>'Tenant','icon'=>'key','color'=>'navy',
     'features'=>['Search rentals with lifestyle filters','Pay rent securely online','Raise and track maintenance requests','Sign digital rental agreements']],
    ['id'=>'owner','role'=>'Property Owner','icon'=>'building','color'=>'gold',
     'features'=>['Manage multiple properties in one dashboard','Track tenants, leases, and renewals','Book trusted home services instantly','Monitor rent collection in real time']],
    ['id'=>'professional','role'=>'Professional','icon'=>'wrench','color'=>'navy',
     'features'=>['Create a professional profile & portfolio','Receive matching service requests','Manage bookings and calendar','Get paid securely, on time, every time']],
  ];
}

function faqs(): array {
  return [
    ['q'=>'How does Homeosphere work?','a'=>"Homeosphere brings property discovery, home services, professional hiring, and property management into one platform. Search or list properties, book verified service professionals, and manage your home — all from a single account."],
    ['q'=>'Are properties verified?','a'=>'Yes. Every listing goes through a verification check covering ownership documents, photos, and key details before it appears on the marketplace. Verified listings carry a green badge.'],
    ['q'=>'How can professionals join?','a'=>'Professionals create a profile, upload their ID and work portfolio, and complete a background and skill check. Once verified, they receive matching service requests from users in their city.'],
    ['q'=>'How do I list my property?','a'=>"Sign in as a seller, click \"List Property\", add photos and details, and submit. Our team verifies the listing, usually within 24 hours, and it goes live with a verified badge."],
    ['q'=>'How are service providers verified?','a'=>'Every professional completes identity verification, a background check, and a skill assessment. Their profile displays a verified badge and real customer reviews so you can book with confidence.'],
    ['q'=>'Is property management available?','a'=>'Yes. Property owners get a full management dashboard to track properties, tenants, rent, maintenance requests, documents, and service history — all in one place.'],
  ];
}
