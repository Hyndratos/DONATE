<?php
	
	/**
	 * Language array
	 * @var array
	 *
	 * When updating this, ONLY change the values on the right hand side.
	 * When I push a Prometheus update there will be a new section at the bottom of the en-gb language file each time there's an update.
	 * If the new values are not set it will fallback to the default ones.
	 *
	 * Norwegian bokmål translation courtesy of myself.
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
		"store" => "Butikk",
		"buy_credits" => "Kjøp credits",
		"raffles" => "Loddtrekning",
		"profile" => "Profil",
		"support" => "Support",
		"admin" => "Admin",
		"sign_out" => "Logg ut",
		"sign_in" => "Logg inn",

		// Header errors and messages
		"not_setup" => "Du har ikke satt opp sysemet ordentlig! <a href='admin.php?a=gen&p=settings'>Klikk her</a> [Admin -> General Settings -> Settings]",
		"header_sandbox" => "PayPal sandkasse modus er aktivert. Bare bruk sandkasse for testing! Du kan deaktivere det <a href='admin.php?a=gen&p=paypal'>her</a>",
		"missing_action" => "En eller flere pakker mangler en aksjon!",
		"unfinished_action" => "Du har en aksjon på 'Profil' siden som ikke er fullført, <a href='profile.php'>her</a>",

		// Frontpage
		"welcome" => "Velkommen - Logg inn",
		"welcome_text" => "Logg inn via Steam for å bruke vår enkele donasjons portal.",

		// News
		"news" => "Nyheter",
		"by" => "Av",
		"no_news" => "Ingen nyheter",
		"no_news_text" => "Det er for øyeblikket ingen nyheter.",
		"no_news_articles" => "Ingen nyhets artikkeler.",

		// Footer
		"tos" => "Tjenestevilkår",
		"powered_by" => "Drives av Steam",

		// Store
		"credits" => "Credits",
		"featured_pkg" => "Utvalgt pakke",
		"permanent" => "Permanent",
		"non_permanent" => "Ikke Permanent",

		"select_credit" => "Velg Credit Pakke",
		"select_raffle" => "Velg lodd Pakke",
		"global_packages" => "Globale Pakker",

		// Raffles
		"raffle_ticket" => "Kjøp lodd",
		"raffle_ended" => "Loddtrekningen har sluttet, vinneren er: ",
		"raffle_not_compatible" => "Denne pakken er ikke kompatibel med en du eier. Tilgang til loddtrekningen nektet.",
		"raffle_already_own" => "Du eier allerede denne pakken. Tilgang til loddtrekningen nektet.",
		"raffle_reached_max" => "Du har nådd maks antall lodd. Tilgang til loddtrekningen nektet.",

		// Support
		"create_ticket" => "Lag ticket",
		"ticket_closed" => "Denne ticketen er låst.",
		"reply" => "Svar",
		"create" => "Lag",

		// Terms of Service
		"tos_edited" => "ToS har blitt redigert. <a href='tos.php'>Terms of Service</a> aksepter den før du kjøper en pakke!",
		"tos_must_accept" => "Du må akseptere ToS før du kjøper en pakke!!",
		"tos_accept" => "Aksepter",

		// Purchase buttons
		"purchase_paypal" => "Kjøp med Paypal",
		"purchase_credits" => "Kjøp med Credits",
		"purchase" => "Kjøp",
		"buy_sign_in" => "Du må logge inn før du kjøper!",
		"buy_already_own" => "Du eier allerede denne pakken!",
		"buy_not_compatible" => "Denne pakken er ikke kompatibel med en du eier!",
		"buy_they_already_own" => "Denne personen eier allerede denne pakken!",
		"buy_they_not_compatible" => "Denne pakken er ikke kompatibel med en pakke de eier!",

		// Packages
		"buying_someone_else" => "Kjøper du for noen andre?",
		"buying_yourself" => "Du kjøper for øyeblikket for deg selv",
		"buying_for" => "Du kjøper for øyeblikket for",
		"packages_custom_amount" => "Egendefinert antall",

		"packages_not_available" => "Ingen pakker tilgjengelig for denne serveren.",
		"raffle_not_available" => "Ingen lotteri pakker tilgjengelig for øyeblikket.",
		"credit_not_available" => "Ingen credit pakker tilgjengelig for øyeblikket.",

		// Buttons
		"submit" => "Send inn",

		// Profile
		"non_perm_pkg" => "Ikke-Permanent Pakke",
		"perm_pkg" => "Permanent(e) pakke(r)",
		"acc_info" => "Bruker Informasjon",
		"pkg_history" => "Pakke Historikk",
		"acc_credits" => "Credits",
		"transfer_credits" => "Overfør Credits",
		"package" => "Pakke",

		// Tables
		"id" => "ID",
		"user" => "Bruker",
		"description" => "Beskrivelse",
		"timestamp" => "Tidsstempel",
		"action" => "Aksjon",
		"replies" => "Svar",
		"view" => "Vis",

		// Select boxes
		"select_server" => "Velg server:",
		"select_currency" => "Velg valuta:",
		"select_category" => "Velg kategori:",
		"none" => "Ingen",

		// Modals
		"yes" => "Ja",
		"no" => "Nei",
		"sure" => "Er du sikker?",
		"sure_cur" => "Er du sikker på at du vil slette denne valutaen?",
		"sure_srv" => "Er du sikker på at du vil slette denne serveren?",
		"sure_cat" => "Er du sikker på at du vil slette denne kategorien?",

		// Dangerous settings
		"dangerous" => "Farlige innstillinger",
		"danger_cur" => "Eller, så kan du slette denne valutaen.",
		"danger_srv" => "Ikke slett denne serveren ved mindre ingen pakker er tilordnet den!",
		"danger_cat" => "Ikke slett denne kategorien ved mindre ingen pakker er tilordnet den!",
		"delete" => "Slett",

		// Admin nav
		"dashboard" => "Dashbord",
		"general_settings" => "Generelle innstillinger",
		"support_tickets" => "Support tickets",
		"servers" => "Servere",
		"currencies" => "Valuter",
		"categories" => "Kategorier",
		"packages_and_actions" => "Pakker & aksjoner",
		"credit_packages" => "Credit pakker",
		"raffles" => "Loddtrekninger",
		"theme_editor" => "Tema editor",
		"documentation" => "Dokumentasjon",

		// General Settings
		"settings" => "Innstillinger",
		"main_page" => "Hovedside",
		"integration_settings" => "Integrerings Instillinger",
		"ingame_notifications" => "Spill Notifikasjoner",

		// Servers page
		"add_srv" => "Legg til server",
		"edit_srv" => "Rediger server",
		"server_name" => "Server Navn",
		"featured_pkg_short" => "Utvalgt pkg",

		// Currency page
		"add_cur" => "Legg til valuta",
		"edit_cur" => "Rediger valuta",
		"cc" => "Valuta Kode",

		// Category page
		"add_cat" => "Legg til kategori",
		"edit_cat" => "Rediger kategori",
		"cat_name" => "Kategori Navn",

		// Dashboard nav
		"main_dashboard" => "Hoved dashbord",
		"sale" => "Salg",
		"transactions" => "Transaksjoner",
		"users" => "Brukere",
		"logs" => "Logger",
		"update_sql" => "Oppdater SQL",
		"other_features" => "Andre Funksjoner",

		// Admin dashboard
		"total" => "Total",
		"full_total" => "Full total",
		"dashboard_text" => "Velkommen til admin dashbordet, dette er hvor du kan se fancy statistikker over din eller dine servere sin donasjons aktivitet.",

		/** 
		 * New in 1.4.7.2
		 */
		"welcome_main" => "Velkommen",
		"need_credits" => "Trenger mer credits? <a href='store.php?page=credits'>Klikk her!</a>",
		"no_history" => "Ingen historikk",
		"amount" => "Antall",
		"you_have_none" => "Du har ingen!",

		"add_cre" => "Legg til credit pakke",
		"edit_cre" => "Rediger credit pakke",
		"pack_title" => "Pakke tittel",
		"price" => "Pris",
		"currency" => "Valuta",
		"sure_cre" => "Er du sikker på at du vil slette denne credit pakka?",
		"danger_cre" => "Eller, så kan du slette denne credit pakka.",
		"select_package" => "Velg pakke:",
		"choose_cre" => "Velg credit pakke",
		"brief_desc" => "Liten beskrivelse",
		"amt_of_cre" => "Antall credits",
		"price_of_pkg" => "Pris av pakke",
		"no_support" => "Du har ingen support tickets!",
		"no_other_available" => "Ingen andre pakker er tilgjengelig",

		/** 
		 * New in 1.4.8
		 */
		"purchase_free" => "Få denne pakken gratis!",
		"dashboard_revenuegraph" => "Fortjenelse tabell",
		"dashboard_revenuecurrency" => "Vist i hovedvalutaen din",
		"dashboard_packagesgraph" => "Pakke salg",
		"dashboard_serversgraph" => "Server salg",
		"between" => "Mellom",
		"and" => "Og",

		/** 
		 * New in 1.4.9
		 */
		"free" => "Gratis",
		"buy_own_free" => "Du eier allerede denne pakken. Du kan ikke få den to ganger!",

         /**
         * New in 1.4.9.2
         */
        "updates" => "Oppdateringer",

       	/**
		 * New in 1.4.9.3
		 */
		"header_sqlupdate" => "Du har en ny MySQL oppdatering <a href='admin.php?update'>her!</a>",
		"monthly_goal" => "Månedtlig mål",

		/**
		 * New in 1.4.9.6
		 */
		"payment_success" => "Betaling fullført!",
		"profile_updated" => "Profilen din har blitt oppdatert.",
		"payment_failed" => "Betalingsfeil!",
		"check_credits" => "Vennligst sjekk at du har nok credits!",
		"not_authorised" => "Du har ikke dagang til å se denne siden. Logg inn først!",

		/**
		 * New in 1.5
		 */
		"wiki" => "Wiki",
		"no_graph_info" => "Ingen grafisk info",
		"no_graph_info_text" => "Viser ingen grafer fordi du ikke har noen transaksjoner ennå",
		"paymentwall_purchase" => "Kjøp via Paymentwall",
		"stripe_purchase" => "Kjøp via Stripe",
		"payment_gateways" => "Betalingsportaler",
		"advanced" => "Avansert",
		"no_servers" => "Ingen servere tilgjengelig.",
		"entries" => "entries",
		"you_can_enter" => "Du kan kjøpe",
		"times_more" => "fler(e) lodd",
		"dashboard_creditsrevenue" => "Denne grafen sammenlikner credits og penger, selvom credits kan bare kjøpes med penger. (Credits = <font color='#9c9c9c'><b>Grå</b></font>, Penger = <font color='#c10000'><b>Rød</b></font>)",
		"pkg_discounted" => "Du har rabbat på denne pakken siden du eier",

		"compatible_text" => "Hvis du eier denne pakken, kan du ikke få pakkene valgt nedenfor",
		"not_compatible" => "Ikke kompatibel med",

		"packages" => "Pakker",
		"upgradeable_text" => "Hvis du eier den valgte pakken så får du denne pakken minus prisen av pakken du eier",
		"upgradeable" => "Oppgraderbar med",

		"assign_actions" => "Velg aksjoner",
		"actions_text" => "Velg hvilken aksjoner denne pakken skal utføre når den har blitt kjøpt av en spiller.",
		"actions" => "Aksjoner",
		"servers" => "Servere",
		"label_amount" => "Etikkete antall",
		"add_package" => "Legg til pakke",
		"edit_package" => "Rediger pakke",
		"labels" => "Etikketer",
		"title" => "Tittel",
		"category" => "Kategorier",
		"no_packages" => "Det finnes ingen pakker i systemet ennå",

		/**
		 * New in 1.5.0.2
		 */
		"hide" => "Gjem denne pakken",
		"hide_text" => "Hvis du ikke eier noen av pakkene valgt nedenfor, så gjemmer du denne pakken fra butikken",
		
		/**
		 * New in 1.5.0.6
		 */
		"signin" => "Logg inn",
		"welcome_signin" => "Du må logge inn før du kan kjøpe pakker",
		"blacklist_notext" => "Du må skrive inn en gyldig Steam64 eller SteamID!",
		"blacklist_success" => "Du har lagt til denne personen i svartelisten!",
		"blacklisted_you" => "You are blacklisted from purchasing any package on this community",
		"blacklisted_them" => "This person is blacklisted from this community, you can not purchase for them",

		"recent_donators" => "Nye donators",
		"name" => "Navn",
		"recent_none" => "Det har ikke vært noen nye donators",
		"raffle_free" => "Bli med gratis!",

		/**
		 * New in 1.5.0.8
		 */
		"top_donators" => "Topp 3 donators",
		"top_none" => "Det er ingen topp donators",

		/**
		 * New in 1.5.0.9
		 */
		"step" => "Steg",

		/**
		 * New in 1.5.1
		 */
		"permission_groups" => "Tilatelses grupper",
		"add_permission" => "Legg til tilatelses gruppe",
		"edit_permission" => "Rediger tilatelses gruppe",
		"permissions" => "Tilatelser",
		"no_perm" => "Du har ikke tilgang til denne funksjonen",

		/**
		 * New in 1.5.1.2
		 */
		"select_gateway" => "Velg betalingsmetode",


		/**
		 * New in 1.5.2
		 */
		"buy_disable" => "Deaktiver pakker",
		"buy_disable_text" => "Deaktiver disse pakkene når du kjøper denne pakken",

		"credits_doesntexist" => "Denne brukeren eksisterer ikke på systemet.",
		"credits_yourself" => "Du kan ikke overføre credits til deg selv.",
		"credits_steamid" => "Prøv en annen SteamID",
		"credits_transferringto" => "Overfører til:",

		"type" => "Type",
		"gateway" => "Betalingsportal",
		"no_users" => "Ingen brukere funnet",

		"view_profile" => "Se profil",
		"view_blacklist" => "Se svarteliste",

		"manage" => "Rediger",
		"users_search" => "Søk etter navn, steam64 eller Steam-ID",

		"transaction" => "Transaksjon",
		"delivered" => "Levert",
		"state" => "Status",
		"assign_package" => "Gi pakke",
		"set_credits" => "Sett credits",
		"give_ticket" => "Gi bilett",
		"del_inactive_actions" => "Slett inaktive aksjoner",

		"select_pkg" => "Velg pakke",
		"do_assign_actions" => "Gi aksjoner",
		"dont_assign_actions" => "Ikke gi aksjoner",
		"clone_expiretime" => "Klon utløpelsesdato fra siste pakke av samme type",
		"assign" => "Gi",

		"set" => "Sett", 
		"disable" => "Slå av",
		"enable" => "Slå på",
		"inactive_everyone" => "Sett inaktiv for alle",
		"del" => "Slett",
		"edit" => "Rediger",

		"sale_settings" => "Salg innstillinger",
		"sale_text" => "Velg hvilken pakker du vil at salget skal gjelde for.",
		"message" => "Melding",
		"percentage" => "Prosent",
		"end_date" => "Slutt dato",

		"update" => "Oppdater",
		"automatic_updates" => "Automatiske oppdatering",
		"dl_lua" => "Last ned nyeste lua",
		"dl_web" => "Last ned nyeste web",
		"no_write_perm" => "Din 'updates' mappe har ikke riktig tilganger! Automatiske oppdateringer vil ikke funke uten chmod 777. <br> Men du kan forøvrig bruke disse knappene til å laste ned siste oppdatering:",
		"newest_version" => "Nyeste tilgjengelige oppdatering er:",

		"test_message" => "Send test melding til server",

		/**
		 * New in 1.5.2.2
		 */
		
		"find_more" => "Finn ut mer!",

		/**
		 * New in 1.5.3
		 */
		
		"duplicate" => "Dupliser pakke",
		"other" => "Annet",
		"someone_else" => "Uansett, du kan fortsatt kjøpe den for noen andre",

		/**
		 * New in 1.5.4 -- Do not replace $1, $2, $3 etc, they get replaced with numbers and stuff automatically, so keep them there!
		 */
		
		"custom_job" => "Egendefinert jobb",

		"here" => "her", // This is $1 in 'job_already_created' because it's wrapped in a link
		"job_already_created" => "Du har allerede laget en egendefinert jobb. Hvis du vil dra rett til checkout klikk $1. Hvis ikke så kan du lage en ny nå",
		
		"general_info" => "Generell informasjon",
		"preferences" => "Preferanser",

		"job_name" => "Jobb navn",
		"chat_cmd" => "Chat kommando for å bli denne jobben",
		"job_desc" => "Jobb beskrivelse",
		"job_colour" => "Jobb farge",

		"weapons" => "Våpen",
		"models" => "Modeller",
		"model" => "Modell",
		
		"job_costs" => "Koster $1 eller $2 credits",

		"friends" => "Venner",
		"friends_max" => "<h6>Venner - maks $1</h6>",
		"friends_add" => "For hver venn du legger blir det lagt til $1 eller $2 credits til den endelige prisen",
		"friends_not" => "Du har ikke lov til å legge til noen venner til denne pakka",

		"salary" => "Lønn",
		"salary_static" => "Din lønn vil være $1",
		"salary_base" => "Lønns basisen er $1. For hvert nummer blir det lagt til $2 eller $3 credits til den endelige prisen",
		"salary_max" => "<h6>Lønn - kan skaleres maks $1 ganger</h6>",
		"salary_current" => "Din foreløpige lønn er: $1",

		"license" => "Lisens",
		"license_included" => "Du får en lisens inkludert i denne jobben",
		"license_include" => "Inkluder lisens - Koster $1 eller $2 credits",
		"license_no" => "Du får ikke en lisens",

		"payment_confirmation" => "Betalingskonfirmasjon",
		"job_total" => "Din totale sum er $1 eller $2 credits",
		"job_proceed" => "Fortsett til betalingsportalen",

		/**
		 * New in 1.5.5
		 */
		
		"job_total_nocredits" => "Din totale sum er $1",
		"job_total_onlycredits" => "Din totale sum er $1 credits",
		
		"earned_total" => "TJENT TOTALT",
		"earned_week" => "TJENT DENNE UKA",
		"earned_month" => "TJENT DENNE MÅNEDEN",

		"real_transaction" => "Tell som ordentlig betaling",
		"not_real_transaction" => "Ikke tell som ordentlig betaling (Vil ikke legge til penger til statistikken)",
		
		/**
		 * New in 1.6
		 */

		"active_everyone" => "Sett aktiv for alle",
		"buy_others_disabled" => "Å kjøpe for andre er skrudd av på dette systemet",
		"job_skip_prize" => "Skip - Bare klikk denne knappen om du ikke vil ha raffle premien din",

		"move_packages" => "Klikk $1 for å flytte pakker rundt",

		"add" => "Legg til",
		"edit" => "Rediger",

		// Theme
		"theme" => "Tema",
		"danger_theme" => "Ikke slett dette temaet om du bruker det akkurat nå!",
		"sure_theme" => "Er du sikker på at du vil slette dette temaet?",
		"theme_name" => "Tema navn",

		"edit_theme" => "Rediger tema",
		"add_theme" => "Legg til tema",
		"select_theme" => "Velg tema",

		// Imprint page
		"imprint" => "Forlag",
		"enable_imprint" => "Skru på forlag",
		"company_name" => "Firma navn",
		"street_address" => "Gate adresse",
		"post_address" => "Post addresse",
		"country" => "Land",
		"trade_register" => "Handelsregister",
		"company_id" => "Firma ID",
		"company_ceo" => "CEO",
		"contact_email" => "Kontakt email",
		"contact_phone" => "Kontakt tlf",

		/**
		 * New in 1.6.1
		 */
		"game" => "Spill",
		"server_ip" => "Server IP",
		"server_port" => "Server port",
		"server_rcon" => "Server RCon",

		"edit_raffle" => "Rediger trekning",
		"add_raffle" => "Legg til trekning",
		"select_raffle" => "Velg trekning:",

		"package_cantbuy" => "Du kan ikke kjøpe denne pakken uten å eie en av de følgende: $1",
		"package_they_cantbuy" => "Du kan ikke kjøpe denne pakken for denne person uten at de eier en av de følgende: $1",

		"hide" => "Hvis du ikke eier noen av disse pakkene, kan du ikke få denne",
		"hide_text" => "Hvis du ikke eier noen av pakkene nedenfor kan du ikke kjøpe denne",

		"your_spendings" => "Ditt forbruk de siste 5 månedene",
		"spendings_currency" => "Dette forbruket er vist i nettsidens hovedvaluta [$1]. Denne grafen sammenlikner penger brukt med credits brukt. (Credits = <font color='#9c9c9c'><b>Gray</b></font>, Penger = <font color='#c10000'><b>Red</b></font>)",
	
		"spent_total" => "TOTALT BRUKT",
		"spent_week" => "BRUKT DENNE UKA",
		"spent_month" => "BRUKT DENNE MÅNEDEN",

		/**
		 * New in 1.6.1.5
		 */
		"advent_calendar" => "Advent kalender",
		"advent" => "Advent",
		"day" => "Dag",
		"advent_opened" => "Du har åpnet dag $1 og fått $2!",
		"advent_nopkg" => "Denne dagen har ingen pakker tilknyttet seg, kontakt en administrator om dette",
		"advent_text" => "Få en gratis pakke hver eneste dag fra den første desember, til den 24!(Julaften)",

		/**
		 * New in 1.6.2
		 */
		"coupons" => "Kuponger",
		"add_cou" => "Legg til kupong",
		"edit_cou" => "Rediger kupong",
		"select_cou" => "Velg kupong",
		"sure_cou" => "Er du sikker på at du vil slette denne kupongen?",
		"coupon_text" => "Hvis du har en kupongkode så kan du bruke den her :)",
	);

?>
