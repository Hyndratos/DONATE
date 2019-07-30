<?php
    
    /**
     * Language array
     * @var array
     *
     * When updating this, ONLY change the values on the right hand side.
     * When I push a Prometheus update there will be a new section at the bottom of the en-gb language file each time there's an update.
     * If the new values are not set it will fallback to the default ones.
     *
     * Danish translation courtesy of Nexzer.
     */
    
    /**
     * Text direction
     * @var string
     *
     * LTR = Left to right
     * RTL = Right to left
     */
    $dir = 'ltr';
  
    $lang = array(
  
        // Navigation bar
        "home" => "Hjem",
        "store" => "Butik",
        "buy_credits" => "Køb Credits",
        "raffles" => "Lotteri",
        "profile" => "Profil",
        "support" => "Support",
        "admin" => "Admin",
        "sign_out" => "Log ud",
        "sign_in" => "Log ind",
  
        // Header errors and messages    
        "not_setup" => "Du har ikke sat dit panel up korrekt! <a href='admin.php?a=gen&p=settings'>Klik her</a> [Admin -> General Settings -> Settings]",
        "header_sandbox" => "Paypal sandbox er slået til. Brug kun asndbox for testing! Du kan slå det fra <a href='admin.php?a=gen&p=paypal'>her</a>",
        "missing_action" => "En eller flere pakke mangler en handling!",
        "unfinished_action" => "Du har en ikke færdiggjort handling på 'Profil' siden, <a href='profile.php'>tryk her</a>",
  
        // Frontpage
        "welcome" => "Velkommen - Log ind",
        "welcome_text" => "Log ind med steam for at bruge vores nemme donations system.",
  
        // News
        "news" => "Nyheder",
        "by" => "Af",
        "no_news" => "Ingen nyheder",
        "no_news_text" => "Der er i øjeblikket ingen nyheder.",
        "no_news_articles" => "Ingen nyhedsartikler.",
  
        // Footer
        "tos" => "Servicevilkår",
        "powered_by" => "Drevet af Steam",
  
        // Store
        "credits" => "Credits",
        "featured_pkg" => "Fremhævet Pakke",
        "permanent" => "Permanent",
        "non_permanent" => "Ikke Permanent",
  
        "select_credit" => "Vælg Credit Pakke",
        "select_raffle" => "Vælg Lotteri Pakke",
        "global_packages" => "Globale Pakker",
  
        // Raffles
        "raffle_ticket" => "Køb billet",
        "raffle_ended" => "Lotteriet er over. Vinderen er: ",
        "raffle_not_compatible" => "Denne pakke er ikke kompitibel med en du ejer. Adgang til lotteriet nægtet.",
        "raffle_already_own" => "Du ejer allerede denne pakke. Adgang til lotteriet nægtet.",
        "raffle_reached_max" => "Du har nået det maksimale beløb for lotteri billeter. Adgang til lotteriet nægtet.",
  
        // Support
        "create_ticket" => "Lav en support sag",
        "ticket_closed" => "Denne sag er lukket.",
        "reply" => "Svar",
        "create" => "Opret",
  
        // Terms of Service
        "tos_edited" => "TOS er blevet redigeret. <a href='tos.php'>Servicevilkår</a> acceptere det, før du køber en pakke!",
        "tos_must_accept" => "Du skal acceptere ToS før du kan købe!",
        "tos_accept" => "Accepter",
  
        // Purchase buttons
        "purchase_paypal" => "Køb med Paypal",
        "purchase_credits" => "Køb med Credits",
        "purchase" => "Køb",
        "buy_sign_in" => "Du skal være logget ind før du køber!",
        "buy_already_own" => "Du ejer allerede denne pakke!",
        "buy_not_compatible" => "Denne pakke er ikke kompatibel med en du ejer!",
        "buy_they_already_own" => "Denne person allerede ejer denne pakke!",
        "buy_they_not_compatible" => "Denne pakke er ikke kompatibel med en de ejer!",
  
        // Packages
        "buying_someone_else" => "Køber du til en anden? (Indtast hans/hendes Steam ID her)",
        "buying_yourself" => "Du er i øjeblikket i gang med at købe til dig selv",
        "buying_for" => "Du er i øjeblikket i gang med at køber for",
        "packages_custom_amount" => "Brugerdefineret beløb",
  
        "packages_not_available" => "Ingen pakker er tilgængelige for denne server.",
        "raffle_not_available" => "Ingen lotteri pakker tilgængelige i øjeblikket.",
        "credit_not_available" => "Ingen Kredit pakker tilgængelige i øjeblikket.",
  
        // Buttons
        "submit" => "Indsend",
  
        // Profile
        "non_perm_pkg" => "Ikke-permanente pakke",
        "perm_pkg" => "Permanente pakke(r)",
        "acc_info" => "Bruger Information",
        "pkg_history" => "Pakke historik",
        "acc_credits" => "Credits",
        "transfer_credits" => "Overfør Credits",
  
        // Tables
        "id" => "ID",
        "user" => "Bruger",
        "description" => "Beskrivelse",
        "timestamp" => "Tid",
        "action" => "Handling",
        "replies" => "Besvarelser",
        "view" => "Vis",
  
        // Select boxes
        "select_server" => "Vælg server:",
        "select_currency" => "Vælg valuta:",
        "select_category" => "Vælg kategori:",
        "none" => "None",
  
        // Modals
        "yes" => "Ja",
        "no" => "Nej",
        "sure" => "Er du sikker?",
        "sure_cur" => "Er du sikker på at du vil slette denne valuta?",
        "sure_srv" => "Er du sikker på at du vil slette denne server?",
        "sure_cat" => "Er du sikker på at du vil slette denne kategori?",
  
        // Dangerous settings
        "dangerous" => "Farlige indstillinger",
        "danger_cur" => "Eller alternativt, kan du slette denne valuta.",
        "danger_srv" => "Slet ikke denne server, medmindre ingen pakker er tildelt den!",
        "danger_cat" => "Du må ikke slette denne kategori, medmindre ingen pakker er tildelt den!",
        "delete" => "Slet",
  
        // Admin nav
        "dashboard" => "Instrumentbræt",
        "general_settings" => "Generelle indstillinger",
        "support_tickets" => "Support sager",
        "servers" => "Servers",
        "currencies" => "Valuta",
        "categories" => "Kategorier",
        "packages_and_actions" => "Pakker og handlinger",
        "credit_packages" => "Credit pakker",
        "raffles" => "Lotterier",
        "theme_editor" => "Tema editor",
        "documentation" => "Dokumentation",
  
        // General Settings
        "settings" => "Indstillinger",
        "main_page" => "Forside",
        "integration_settings" => "integrationsindstillinger",
        "ingame_notifications" => "In-game Meddelelser",
  
        // Servers page
        "add_srv" => "Tilføj server",
        "edit_srv" => "Rediger server",
        "server_name" => "Servernavn",
        "featured_pkg_short" => "Udvalgte pkg",
  
        // Currency page
        "add_cur" => "Tilføj valuta",
        "edit_cur" => "Skift valuta",
        "cc" => "Valutakode",
  
        // Category page
        "add_cat" => "Tilføj kategori",
        "edit_cat" => "Ændre kategori",
        "cat_name" => "Kategori navn",
  
        // Dashboard nav
        "main_dashboard" => "Main instrumentbræt",
        "sale" => "Tilbud",
        "transactions" => "Transaktioner",
        "users" => "Brugere",
        "logs" => "Logs",
        "update_sql" => "Opdater SQL",
        "other_features" => "Andre funktioner",
  
        // Admin dashboard
        "total" => "Total",
        "full_total" => "Full total",
        "dashboard_text" => "Velkommen til administratorens instrumentbræt, det er her du vil være i stand til at se fancy statistik af donationerne.",
  
         /**
         * New in 1.4.7.2
         */
        "welcome_main" => "Velkommen!",
        "need_credits" => "Mangler flere credits? <a href='store.php?page=credits'>Klik her!</a>",
        "no_history" => "Ingen historie",
        "amount" => "Antal",
        "you_have_none" => "Du har ingen!",
  
        "add_cre" => "Tilføj credit pakke",
        "edit_cre" => "Ændre credit pakke",
        "pack_title" => "Pakke Titel",
        "price" => "Pris",
        "currency" => "Valuta",
        "sure_cre" => "Er du sikker på du vil slette denne credit pakke?",
        "danger_cre" => "Eller alternativt, kan du slette denne pakke.",
        "select_package" => "Vælg pakke:",
        "choose_cre" => "Vælg credit pakke",
        "brief_desc" => "Beskrivelse",
        "amt_of_cre" => "Antal af credits",
        "price_of_pkg" => "Prisen på pakken",
        "no_support" => "Du har ingen support sager",
        "no_other_available" => "Ingen andre pakker tilgængelige",
  
        /**
         * New in 1.4.8
         */
        "purchase_free" => "Få denne pakke gratis!",
        "dashboard_revenuegraph" => "Indtægt Graf",
        "dashboard_revenuecurrency" => "Vist i din valgte valuta",
        "dashboard_packagesgraph" => "Pakke Salg",
        "dashboard_serversgraph" => "Server Salg",
        "between" => "Mellem",
        "and" => "Og",
  
         /**
         * New in 1.4.9
         */
        "free" => "Gratis",
        "buy_own_free" => "Du har allerede fået denne gratis pakke",
  
         /**
         * New in 1.4.9.2
         */
        "updates" => "Opdateringer",
  
         /**
         * New in 1.4.9.3
         */
        "header_sqlupdate" => "Du har ikke anvendt den nye MySQL opsætning. Opdater <a href='admin.php?update'>her!</a>",
        "monthly_goal" => "Mål for denne måned",
  
        /**
         * New in 1.4.9.6
         */
        "payment_success" => "Betaling fuldført!",
        "profile_updated" => "Din profil er blevet opdateret.",
        "payment_failed" => "Betaling fejlede!",
        "check_credits" => "Tjek venligst om du har nok credits til at købe denne pakke!",
        "not_authorised" => "Du har ikke adgang til denne side. Log ind først!",
  
         /**
         * New in 1.5
         */
        "wiki" => "Wiki",
        "no_graph_info" => "Ingen graf info",
        "no_graph_info_text" => "Viser ikke graf info så længe der ikke er nogen transaktioner!",
        "paymentwall_purchase" => "Køb med Paymentwall",
        "stripe_purchase" => "Køb med Stripe",
        "payment_gateways" => "Betalingsmetoder",
        "advanced" => "Avanceret",
        "no_servers" => "Ingen servere tilgængelige i øjeblikket.",
        "entries" => "Deltagelser",
        "you_can_enter" => "Du kan deltage",
        "times_more" => "gange endnu",
        "dashboard_creditsrevenue" => "Denne graf sammenligner også hvad der er brugt af penge for credits. Although credits are aquired with money. (Credits = <font color='#9c9c9c'><b>Gray</b></font>, Money = <font color='#c10000'><b>Red</b></font>)",
        "pkg_discounted" => "Denne pakke er nedsat fordi du ejer",
  
        "compatible_text" => "Hvis du ejer denne pakke kan du ikke eje de pakker herunder",
        "not_compatible" => "Ikke kompatibel med",
  
        "packages" => "Pakker",
        "upgradeable_text" => "Hvis du ejer den valgte pakke, får du nedsat pris af den valgte pakkes pris.",
        "upgradeable" => "Kan opgraderes fra",
  
        "assign_actions" => "Tildel funktion",
        "actions_text" => "Tildel hvilken funktion du vil have bliver udført efter den bliver købt af en spiller.",
        "actions" => "Funktioner",
        "servers" => "Servere",
        "label_amount" => "Antal af Labels",
        "add_package" => "Tilføj pakke",
        "edit_package" => "Rediger pakke",
        "labels" => "Labels",
        "title" => "Titel",
        "category" => "Kategori",
        "no_packages" => "Du har i øjeblikket ingen pakker i systemet",
  
        /**
         * New in 1.5.0.2
         */
        "hide" => "Skjul denne pakke",
        "hide_text" => "Hvis du ikke ejer den valgte pakke herunder, gem pakken fra butikken",
        
        /**
         * New in 1.5.0.6
         */
        "signin" => "Log ind",
        "welcome_signin" => "Du skal være logget ind for at kunne købe pakker",
        "blacklist_notext" => "Du skal indtaste et gyldigt Steam64 eller SteamID til blacklisten.",
        "blacklist_success" => "Du har hermed blacklistet personen!",
        "blacklisted_you" => "Du er blacklistet fra at købe noget fra dette panel",
        "blacklisted_them" => "Denne person er blevet blacklistet, og du kan derfor ikke købe noget til ham/hende.",
  
        "recent_donators" => "Nyeste donationer",
        "name" => "Navn",
        "recent_none" => "Der er ikke nogen nye donationer.",
        "raffle_free" => "Tilgå gratis!",
  
        /**
         * New in 1.5.0.8
         */
        "top_donators" => "Top 3 donationer",
        "top_none" => "Der er ingen top donationer",
  
        /**
         * New in 1.5.0.9
         */
        "step" => "Skridt",
  
        /**
         * New in 1.5.1
         */
        "permission_groups" => "Permission grupper",
        "add_permission" => "Tilføj permission gruppe",
        "edit_permission" => "Ændre permission gruppe",
        "permissions" => "Permissions",
        "no_perm" => "I'm sorry Dave, I'm afraid I can't let you do that (Ikke nok permissions)",
  
        /**
         * New in 1.5.1.2
         */
        "select_gateway" => "Vælg betalingsmetode",
  
        /**
         * New in 1.5.2
         */
        "buy_disable" => "Deaktiver pakker",
        "buy_disable_text" => "Deaktiver disse pakker hvis du køber denne pakke",
  
        "credits_doesntexist" => "Denne bruger findes ikke i systemet.",
        "credits_yourself" => "Du kan ikke overføre credits til dig selv.",
        "credits_steamid" => "Prøv et andet SteamID",
        "credits_transferringto" => "Overfører til:",
  
        "type" => "Type",
        "gateway" => "Gateway",
        "no_users" => "Ingen brugere fundet",
  
        "view_profile" => "Se profil",
        "view_blacklist" => "Se blackliste",
  
        "manage" => "Administrer",
        "users_search" => "Søg efter navn, steam64 eller steamid",
  
        "transaction" => "Transaktion",
        "delivered" => "Leveret",
        "state" => "Tilstand",
        "assign_package" => "Tildel pakke",
        "set_credits" => "Sæt credits",
        "give_ticket" => "Giv ticket",
        "del_inactive_actions" => "Slet inaktive handlinger",
  
        "select_pkg" => "Vælg pakke",
        "do_assign_actions" => "Tildel handlinger",
        "dont_assign_actions" => "Do not assign actions",
        "clone_expiretime" => "Clone expiretime of latest package of same type",
        "assign" => "Assign",
  
        "set" => "Set",
        "disable" => "Disable",
        "enable" => "Enable",
        "inactive_everyone" => "Sæt som inaktiv for alle",
        "del" => "Slet",
        "edit" => "Ændre",
  
        "sale_settings" => "Tilbuds indstillinger",
        "sale_text" => "Vælg den pakke du vil lave tilbud på.",
        "message" => "Besked",
        "percentage" => "Procent",
        "end_date" => "Slut dato",
  
        "update" => "Opdater",
        "automatic_updates" => "Automatiske opdateringer",
        "dl_lua" => "Download seneste lua",
        "dl_web" => "Download seneste web",
        "no_write_perm" => "Din opdateringsmappe har ikke skrive-tilladelse! Automatiske opdateringer virker ikke medmindre du chmod det til 777. <br> Du kan dog bruge denne knap til at hente opdateringen manuelt",
        "newest_version" => "Nyeste tilgængelige opdatering er:",
  
        "test_message" => "Send en testbesked til serveren",
  
       /**
         * New in 1.5.2.2
         */
        
        "find_more" => "Læs mere!",
  
        /**
         * New in 1.5.3
         */
        
        "duplicate" => "Duplikering",
        "other" => "Andet",
        "someone_else" => "Dog kan du stadig købe det til en anden",
  
        /**
         * New in 1.5.4 -- Do not replace $1, $2, $3 etc, they get replaced with numbers and stuff automatically, so keep them there!
         */
        
        "here" => "her", // This is $1 in 'job_already_created' because it's wrapped in a link
        "job_already_created" => "Du har allerede oprettet et custom job. Hvis du vil fortsætte direkte til check-ud $1. Ellers kan du oprette et nyt",
        
        "general_info" => "Generel information",
        "preferences" => "Præferencer",
  
        "job_name" => "Job navn",
        "chat_cmd" => "Chat kommando for at blive dette job",
        "job_desc" => "Job beskrivelse",
        "job_colour" => "Job farve",
  
        "weapons" => "Våben",
        "models" => "Modeller",
        "model" => "Model",
        
        "job_costs" => "Koster $1 eller $2 credits",
  
        "friends" => "Venner",
        "friends_max" => "<h6>Venner - $1 maximum</h6>",
        "friends_add" => "For hver ven du tilføjer, tilføjes $1 eller $2 credits til den endelige pris",
        "friends_not" => "Du kan ikke tilføje venner til denne pakke",
  
        "salary" => "Løn",
        "salary_static" => "Din løn vil blive $1",
        "salary_base" => "Startlønnen er $1. For hvert tal du forøger med, tilføjes $2 eller $3 til den endelige pris",
        "salary_max" => "<h6>Løn - $1 max gange til udgangspunkt</h6>",
        "salary_current" => "Din nuværende løn er: $1",
  
        "license" => "License",
        "license_included" => "Du får en license med i jobbet",
        "license_include" => "Inkluder license - Koster $1 eller $2 credits",
        "license_no" => "Du får ingen license",
  
        "payment_confirmation" => "Betalings bekræftelse",
        "job_total" => "Din nuværende saldo er $1 eller $2 credits",
        "job_proceed" => "Fortsæt til check-out",
  
        /**
         * New in 1.5.5
         */
        
        "job_total_nocredits" => "Din nuværende saldo er $1",
        "job_total_onlycredits" => "Din nuværende saldo er $1 credits",
        
        "earned_total" => "TJENT I ALT",
        "earned_week" => "TJENT DENNE UGE",
        "earned_month" => "TJENT DENNE MÅNED",
  
        "real_transaction" => "Tag som en rigtig transaktion",
        "not_real_transaction" => "Tag ikke som en rigtig transaktion (tilføjer ikke penge til statistikker)",
        
        /**
         * New in 1.6
         */
  
        "active_everyone" => "Sæt som aktiv for alle",
        "buy_others_disabled" => "Køb til andre er deaktiveret",
        "job_skip_prize" => "Spring over - klik kun her hvis du ikke vil modtage raffle præmier",
  
        "move_packages" => "Klik $1 for at rykke pakker rundt",
  
        "add" => "Tilføj",
        "edit" => "Ændre",
  
        // Theme
        "theme" => "Tema",
        "danger_theme" => "Slet ikke dette tema medmindre du ikke bruger det!",
        "sure_theme" => "Er du sikker på at du vil slette dette tema?",
        "theme_name" => "Tema navn",
        
        "edit_theme" => "Ændre tema",
        "add_theme" => "Tilføj tema",
        "select_theme" => "Vælg tema",
  
        // Imprint page
        "imprint" => "Aftryk",
        "enable_imprint" => "Aktiver aftryk",
        "company_name" => "Firma navn",
        "street_address" => "Vejnavn",
        "post_address" => "Adresse",
        "country" => "Land",
        "trade_register" => "Handelsregister",
        "company_id" => "Firma ID",
        "company_ceo" => "CEO",
        "contact_email" => "Kontakt e-mail",
        "contact_phone" => "Kontakt telefon",
  
        /**
         * New in 1.6.1
         */
        "game" => "Spil",
        "server_ip" => "Server IP",
        "server_port" => "Server port",
        "server_rcon" => "Server RCon",
  
        "edit_raffle" => "Ændre raffle",
        "add_raffle" => "Tilføj raffle",
        "select_raffle" => "Vælg raffle:",
  
        "package_cantbuy" => "Du kan ikke købe denne pakke uden at eje: $1",
        "package_they_cantbuy" => "De kan ikke købe denne pakke uden at eje: $1",
  
        "hide" => "Hvis du ikke ejer en af disse pakker, kan du ikke få den her",
        "hide_text" => "Hvis du ikke ejer en af de valgte pakker, kan du ikke få denne pakke",
  
        "your_spendings" => "Dine betalinger de seneste 5 måneder",
        "spendings_currency" => "Disse betalinger er vist i sidens valuta [$1]. Denne graf viser credits brugt i forhold til penge. Selvom credits fås ved køb. (Credits = <font color='#9c9c9c'><b>Grå</b></font>, Penge = <font color='#c10000'><b>Rød</b></font>)",
    
        "spent_total" => "BETALT I ALT",
        "spent_week" => "BETALT DENNE UGE",
        "spent_month" => "BETALT DENNE MÅNED",
  
        /**
         * New in 1.6.1.5
         */
        "advent_calendar" => "Adventskalender",
        "advent" => "Advent",
        "day" => "Dag",
        "advent_opened" => "Du har åbnet dag $1 og har modtaget $2!",
        "advent_nopkg" => "Denne dag har ingen pakke tilknyttet. Kontakt community administratoren angående dette",
        "advent_text" => "Få en gratis pakke alle dage i december. Det starter den 1. december og helt til juleaften (24. december)!",
  
        /**
         * New in 1.6.2
         */
        "coupons" => "Rabatkode",
        "add_cou" => "Tilføj rabatkode",
        "edit_cou" => "Ændre rabatkode",
        "select_cou" => "Vælg rabatkode",
        "sure_cou" => "Er du sikker på at du vil slette denne rabatkode?",
        "coupon_text" => "Hvis du har en rabatkode kan du tilføje den her :)",
    );
  
?>
