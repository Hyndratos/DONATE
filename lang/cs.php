<?php
	
	/**
	 * Language array
	 * @var array
	 *
	 * When updating this, ONLY change the values on the right hand side.
	 * When I push a Prometheus update there will be a new section at the bottom of the en-gb language file each time there's an update.
	 * If the new values are not set it will fallback to the default ones.
	 */
	$lang = array(

		// Navigation bar
		"home" => "Domov",
		"store" => "Obchod",
		"buy_credits" => "Koupit kredity",
		"raffles" => "Tombola",
		"profile" => "Profil",
		"support" => "Podpora",
		"admin" => "Admin",
		"sign_out" => "Odhlásit se",
		"sign_in" => "Přihlásit se",

		// Header errors and messages
		"not_setup" => "Nenastavili jste svůj panel správně! <a href='admin.php?a=gen&p=settings'>Klikněte zde</a> [Admin -> Obecné nastavení -> Nastavení]",
		"header_sandbox" => "PayPal Sandbox je povolen. Používejte pouze pískoviště pro testování! Můžete ho zakázat <a href='admin.php?a=gen&p=paypal'>zde</a>",
		"missing_action" => "Jeden nebo více balíků chybí akce!",
		"unfinished_action" => "Máte nehotové akce na stránce "Profil", <a href='profile.php'>zde</a>",

		// Frontpage
		"welcome" => "Vítejte - Přihlašte se",
		"welcome_text" => "Přihlaste se prostřednictvím Steamu pro využití našeho lehkého donate portálu.",

		// News
		"news" => "Novinky",
		"by" => "Od",
		"no_news" => "Žádné novinky",
		"no_news_text" => "V současné době nejsou žádné novinky.",
		"no_news_articles" => "Žádné novinky.",

		// Footer
		"tos" => "Smluvní podmínky",
		"powered_by" => "Poháněno Steamem",

		// Store
		"credits" => "Kredity",
		"featured_pkg" => "Nejlepší balíček",
		"permanent" => "Permanentní",
		"non_permanent" => "Nepermanentní",

		"select_credit" => "Zvolte Kreditní Balíček",
		"select_raffle" => "Zvolte Tomobolový Balíček",
		"global_packages" => "Globální Balíčky",

		// Raffles
		"raffle_ticket" => "Zakoupit lístek",
		"raffle_ended" => "Tombola skončila, výherce je: ",
		"raffle_not_compatible" => "Tento balíček není kompatibilní s tím, který vlastníte. Vstup do tomboly zakázán.",
		"raffle_already_own" => "Již vlastníte tento balíček. Vstup do tomboly zakázán.",
		"raffle_reached_max" => "Dosáhli jste maximální množství vstupů do tomboly. Vstup do tomboly zakázán.",

		// Support
		"create_ticket" => "Vytvořit tiket",
		"ticket_closed" => "Tento tiket je uzavřen.",
		"reply" => "Odpovědět",
		"create" => "Vytvořit",

		// Terms of Service
		"tos_edited" => "Podmínky služby byli upraveny. <a href='tos.php'>Podmínky služby</a> odsouhlaste je před tím, než si koupíte balíček!",
		"tos_must_accept" => "Musíte souhlasit s Podmínkami Služby!",
		"tos_accept" => "Souhlasím",

		// Purchase buttons
		"purchase_paypal" => "Zakoupit s PayPalem",
		"purchase_credits" => "Zakoupit s kreditama",
		"purchase" => "Zakoupit",
		"buy_sign_in" => "Musíte být přihlašen, před tím než si něco zakoupíte!",
		"buy_already_own" => "Již vlastníte tento balíček!",
		"buy_not_compatible" => "Tento balíček není kompatibilní s tím, který vlastníte!",
		"buy_they_already_own" => "Tato osoba již vlastní tento balíček!",
		"buy_they_not_compatible" => "Tento balíček není kompatibilní některým, který vlastníte!",

		// Packages
		"buying_someone_else" => "Zakupujete toto pro někoho jiného?",
		"buying_yourself" => "Zakupujete pro sebe.",
		"buying_for" => "Zakupujete pro ",
		"packages_custom_amount" => "Vlastní částka",

		"packages_not_available" => "Žádné balíčky jsou k dispozici pro tento server.",
		"raffle_not_available" => "Žádné tombolové balíčky nejsou k dispozici v současné době.",
		"credit_not_available" => "Žádné kreditové balíčky nejsou k dispozici v současné době.",

		// Buttons
		"submit" => "Potvrdit",

		// Profile
		"non_perm_pkg" => "Nepermanentní Balíček",
		"perm_pkg" => "Permanentní Balíček/ky",
		"acc_info" => "Informace O Účtu",
		"pkg_history" => "Historie Balíčků",
		"acc_credits" => "Kredity",
		"transfer_credits" => "Přenést Kredity",
		"package" => "Balíček",

		// Tables
		"id" => "ID",
		"user" => "Použivatel",
		"description" => "Popis",
		"timestamp" => "Čas",
		"action" => "Akce",
		"replies" => "Odpovědi",
		"view" => "Otevřít",

		// Select boxes
		"select_server" => "Zvolte server:",
		"select_currency" => "Zvolte měnu:",
		"select_category" => "Zvolte kategorii:",
		"none" => "None",

		// Modals
		"yes" => "Ano",
		"no" => "Ne",
		"sure" => "Jste si jisti?",
		"sure_cur" => "Jste si jisti, že chcete smazat tuto měnu?",
		"sure_srv" => "Jste si jisti, že chcete smazat tento server?",
		"sure_cat" => "Jste si jisti, že chcete smazat tuto kategorii?",

		// Dangerous settings
		"dangerous" => "Nebezpečné nastavení",
		"danger_cur" => "Nebo alternativně, můžete odstranit tuto měnu.",
		"danger_srv" => "Neodstraňujte tento server, pokud jsou k němu přiřazeny balíčky!",
		"danger_cat" => "Neodstraňujte tuto kategorii, pokud jsou k ní přiřazeny balíčky!",
		"delete" => "Smazat",

		// Admin nav
		"dashboard" => "Hlavní menu",
		"general_settings" => "Všeobecné nastavení",
		"support_tickets" => "Podporové tikety",
		"servers" => "Servery",
		"currencies" => "Měny",
		"categories" => "Kategorie",
		"packages_and_actions" => "Balíčky & akce",
		"credit_packages" => "Kreditové balíčky",
		"raffles" => "Tombola",
		"theme_editor" => "Editor témy",
		"documentation" => "Manuál",

		// General Settings
		"settings" => "Nastavení",
		"main_page" => "Hlavní stránka",
		"integration_settings" => "Nastavení integrace",
		"ingame_notifications" => "Upozornění ve hře",

		// Servers page
		"add_srv" => "Přidat server",
		"edit_srv" => "Upravit server",
		"server_name" => "Jméno Serveru",
		"featured_pkg_short" => "Nejlepší balíček",

		// Currency page
		"add_cur" => "Přidat měnu",
		"edit_cur" => "Upravit měnu",
		"cc" => "Kód měny",

		// Category page
		"add_cat" => "Přidat kategorii",
		"edit_cat" => "Upravit kategorii",
		"cat_name" => "Jméno Kategorie",

		// Dashboard nav
		"main_dashboard" => "Hlavní menu",
		"sale" => "Sleva",
		"transactions" => "Transakce",
		"users" => "Uživatelé",
		"logs" => "Záznamy",
		"update_sql" => "Aktualizovat SQL",
		"other_features" => "Jiné funkce",

		// Admin dashboard
		"total" => "Celkově",
		"full_total" => "Plný celek",
		"dashboard_text" => "Vítejte na hlavním menu správce, zde si budete moci prohlížet statistiky o penězích z vašich serverů.",

		/** 
		 * New in 1.4.7.2
		 */
		"welcome_main" => "Vítejte",
		"need_credits" => "Potřebujete víc kreditů? <a href='store.php?credits'>Klikněte zde!</a>",
		"no_history" => "Žádná historie",
		"amount" => "Hodnota",
		"you_have_none" => "Nemáte nic!",

		"add_cre" => "Přidat kreditový balíček",
		"edit_cre" => "Upravit kreditový balíček",
		"pack_title" => "Název balíčku",
		"price" => "Cena",
		"currency" => "Měna",
		"sure_cre" => "Jste si jisti, že chcete smazat tento kreditový balíček?",
		"danger_cre" => "Nebo alternativně, můžete odstranit tento kreditní balíček.",
		"select_package" => "Vybrat balíček:",
		"choose_cre" => "Zvolit kreditový balíček",
		"brief_desc" => "Stručný popis",
		"amt_of_cre" => "Množství kreditů",
		"price_of_pkg" => "Cena balíčku",
		"no_support" => "Nemáte žádné podpůrné tikety",
		"no_other_available" => "Žádné další balíčky nejsou k dispozici",

		/** 
		 * New in 1.4.8
		 */
		"purchase_free" => "Získej tento balíček zdarma!",
		"dashboard_revenuegraph" => "Graf příjmů",
		"dashboard_revenuecurrency" => "Zobrazovat ve vaší hlavní měně",
		"dashboard_packagesgraph" => "Prodej balíčků",
		"dashboard_serversgraph" => "Výnos serverů",
		"between" => "Mezi",
		"and" => "A",

		/**
		 * New in 1.5
		 */
		"wiki" => "Wiki",
		"no_graph_info" => "Graf je nedostupný.",
		"no_graph_info_text" => "Nezobrazuji graf kvůli žádným nedávným transakcí.",
		"paymentwall_purchase" => "Zaplatit přes Paymentwall",
		"stripe_purchase" => "Zaplatit přes Stripe",
		"payment_gateways" => "Platební brány",
		"advanced" => "Pokročilé",
		"no_servers" => "Žádné servery nejsou v tuto chvíli dostupné..",
		"entries" => "vstupy",
		"you_can_enter" => "Můžete vstoupit",
		"times_more" => "krát",
		"dashboard_creditsrevenue" => "Tento graf porovnává peníze a kredity, které byly utraceny. I přes to že kredity se získávají penězmi. (Kredity = <font color='#9c9c9c'><b>Šedé</b></font>, Peníze = <font color='#c10000'><b>Červené</b></font>)",
		"pkg_discounted" => "Tento balíček je zlevněn protože jste si koupil",

		"compatible_text" => "Pokud vlastníte tento balíček, nemůžete si zakoupit balíčky podtím.",
		"not_compatible" => "Nekompatibilní s",

		"packages" => "Balíčky",
		"upgradeable_text" => "If you own the package selected, you get this one at a discounted price of the selected packages' price",
		"upgradeable" => "Upgradovatelné s",

		"assign_actions" => "Přiřadit funkce",
		"actions_text" => "Zde přidejte akce které chcete aby se staly až si hráč koupí balíček.",
		"actions" => "Akce",
		"servers" => "Servery",
		"label_amount" => "Label amount", /* Idk how to translate this */
		"add_package" => "Přidat balíček",
		"edit_package" => "Upravit balíček",
		"labels" => "Labels",
		"title" => "Název",
		"category" => "Kategorie",
		"no_packages" => "V této době nemáte žádné balíčky v systému.",

		/**
		 * New in 1.5.0.2
		 */
		"hide" => "Hide this package",
		"hide_text" => "If you dont own one of the packages selected below, hide this package from the store",
		
		/**
		 * New in 1.5.0.6
		 */
		"signin" => "Sign in",
		"welcome_signin" => "You need to sign in first in order to buy any packages",
		"blacklist_notext" => "You need to enter a valid Steam64 or SteamID to blacklist!",
		"blacklist_success" => "You have successfully blacklisted this person",
		"blacklisted_you" => "You are blacklisted from purchasing any package on this community",
		"blacklisted_them" => "This person is blacklisted from this community, you can not purchase for them",

		"recent_donators" => "Recent donators",
		"name" => "Name",
		"recent_none" => "There has not been any recent donators",
		"raffle_free" => "Enter for free!",

		/**
		 * New in 1.5.0.8
		 */
		"top_donators" => "Top 3 donators",
		"top_none" => "There are no top donators",

		/**
		 * New in 1.5.0.9
		 */
		"step" => "Step",

		/**
		 * New in 1.5.1
		 */
		"permission_groups" => "Permission groups",
		"add_permission" => "Add permission group",
		"edit_permission" => "Edit permission group",
		"permissions" => "Permissions",
		"no_perm" => "I'm sorry Dave, I'm afraid I can't let you do that (Insufficient permisisons)",

		/**
		 * New in 1.5.1.2
		 */
		"select_gateway" => "Select payment method",

		/**
		 * New in 1.5.2
		 */
		"buy_disable" => "Disable packages",
		"buy_disable_text" => "Disable these packages if you buy this package",

		"credits_doesntexist" => "This user does not exist on this system.",
		"credits_yourself" => "You can't transfer credits to yourself.",
		"credits_steamid" => "Try another SteamID",
		"credits_transferringto" => "Transferring to:",

		"type" => "Type",
		"gateway" => "Gateway",
		"no_users" => "No users found",

		"view_profile" => "View profile",
		"view_blacklist" => "View blacklist",

		"manage" => "Manage",
		"users_search" => "Search for name, steam64 or steamid",

		"transaction" => "Transaction",
		"delivered" => "Delivered",
		"state" => "State",
		"assign_package" => "Assign package",
		"set_credits" => "Set credits",
		"give_ticket" => "Give ticket",
		"del_inactive_actions" => "Delete inactive actions",

		"select_pkg" => "Select package",
		"do_assign_actions" => "Assign actions",
		"dont_assign_actions" => "Do not assign actions",
		"clone_expiretime" => "Clone expiretime of latest package of same type",
		"assign" => "Assign",

		"set" => "Set", 
		"disable" => "Disable",
		"enable" => "Enable",
		"inactive_everyone" => "Set inactive for everyone",
		"del" => "Del",
		"edit" => "Edit",

		"sale_settings" => "Sale settings",
		"sale_text" => "Choose what packages you want the sale to apply to.",
		"message" => "Message",
		"percentage" => "Percentage",
		"end_date" => "End date",

		"update" => "Update",
		"automatic_updates" => "Automatic updates",
		"dl_lua" => "Download latest lua",
		"dl_web" => "Download latest web",
		"no_write_perm" => "Your updates folder does not have write permissions! Automatic updates won\'t work unless you chmod it to 777. <br> You can however use this button to manually download the update",
		"newest_version" => "Newest available version is:",

		"test_message" => "Send test message to server",

		/**
		 * New in 1.5.2.2
		 */
		
		"find_more" => "Find out more!",

		/**
		 * New in 1.5.3
		 */
		
		"duplicate" => "Duplicate",
		"other" => "Other",
		"someone_else" => "However, you can still buy it for someone else",

		/**
		 * New in 1.5.4 -- Do not replace $1, $2, $3 etc, they get replaced with numbers and stuff automatically, so keep them there!
		 */
		
		"here" => "here", // This is $1 in 'job_already_created' because it's wrapped in a link
		"job_already_created" => "You have already created a custom job. If you want to proceed straight to checkout click $1. Otherwise you can create a new one",
		
		"general_info" => "General information",
		"preferences" => "Preferences",

		"job_name" => "Job name",
		"chat_cmd" => "Chat command to become this job",
		"job_desc" => "Job description",
		"job_colour" => "Job colour",

		"weapons" => "Weapons",
		"models" => "Models",
		"model" => "Model",
		
		"job_costs" => "Costs $1 or $2 credits",

		"friends" => "Friends",
		"friends_max" => "<h6>Friends - $1 max</h6>",
		"friends_add" => "For every friend you add it adds $1 or $2 credits to the final price",
		"friends_not" => "You are not allowed to add any friends to this package",

		"salary" => "Salary",
		"salary_static" => "Your salary will be $1",
		"salary_base" => "The base salary is $1. For every number you up it by it adds $2 or $3 credits to the final price",
		"salary_max" => "<h6>Salary - $1 max times to scale</h6>",
		"salary_current" => "Your current salary is: $1",

		"license" => "License",
		"license_included" => "You get a license included in the job",
		"license_include" => "Include license - Costs $1 or $2 credits",
		"license_no" => "You do not get a license",

		"payment_confirmation" => "Payment confirmation",
		"job_total" => "Your current total is $1 or $2 credits",
		"job_proceed" => "Proceed to checkout",

		/**
		 * New in 1.5.5
		 */
		
		"job_total_nocredits" => "Your current total is $1",
		"job_total_onlycredits" => "Your current total is $1 credits",
		
		"earned_total" => "TOTAL EARNED",
		"earned_week" => "EARNED THIS WEEK",
		"earned_month" => "EARNED THIS MONTH",

		"real_transaction" => "Count as a real transaction",
		"not_real_transaction" => "Do not count as a real transaction (Will not add money to any stats)",
		
		/**
		 * New in 1.6
		 */

		"active_everyone" => "Set active for everyone",
		"buy_others_disabled" => "Buying for others is disabled on this system",
		"job_skip_prize" => "Skip - Only click this if you do not want to claim this raffle prize",

		"move_packages" => "Click $1 to move packages around",

		"add" => "Add",
		"edit" => "Edit",

		// Theme
		"theme" => "Theme",
		"danger_theme" => "Don't delete this theme unless you are not currently using it!",
		"sure_theme" => "Are you sure you want to delete this theme?",
		"theme_name" => "Theme name",
		
		"edit_theme" => "Edit theme",
		"add_theme" => "Add theme",
		"select_theme" => "Select theme",

		// Imprint page
		"imprint" => "Imprint",
		"enable_imprint" => "Enable imprint",
		"company_name" => "Company name",
		"street_address" => "Street address",
		"post_address" => "Post address",
		"country" => "Country",
		"trade_register" => "Trade register",
		"company_id" => "Company ID",
		"company_ceo" => "CEO",
		"contact_email" => "Contact email",
		"contact_phone" => "Contact phone",

		/**
		 * New in 1.6.1
		 */
		"game" => "Game",
		"server_ip" => "Server IP",
		"server_port" => "Server port",
		"server_rcon" => "Server RCon",

		"edit_raffle" => "Edit raffle",
		"add_raffle" => "Add raffle",
		"select_raffle" => "Select raffle:",

		"package_cantbuy" => "You can't buy this package without owning one of the following: $1",
		"package_they_cantbuy" => "They can't buy this package without owning one of the following: $1",

		"hide" => "If you don't own any of these packages, you can't get this one",
		"hide_text" => "If you dont own one of the packages selected below, then this package can't be bought",

		"your_spendings" => "Your spendings the last 5 months",
		"spendings_currency" => "These spendings are shown in this websites main currency [$1]. This graph compares credits spent to money spent. Although credits are aquired with money. (Credits = <font color='#9c9c9c'><b>Gray</b></font>, Money = <font color='#c10000'><b>Red</b></font>)",
	
		"spent_total" => "TOTAL SPENT",
		"spent_week" => "SPENT THIS WEEK",
		"spent_month" => "SPENT THIS MONTH",

		/**
		 * New in 1.6.1.5
		 */
		"advent_calendar" => "Advent calendar",
		"advent" => "Advent",
		"day" => "Day",
		"advent_opened" => "You have opened day $1 and received $2!",
		"advent_nopkg" => "This day has no package assigned to it, please contact your community's administrator about this",
		"advent_text" => "Get one free package every single day starting from the 1st of December to the Christmas Eve, the 24th!",

		/**
		 * New in 1.6.2
		 */
		"coupons" => "Coupons",
		"add_cou" => "Add coupon",
		"edit_cou" => "Edit coupon",
		"select_cou" => "Select coupon",
		"sure_cou" => "Are you sure you want to delete this coupon?",
		"coupon_text" => "If you have a coupon code you can add it here :)",
	);

?>
