<?php
	
	/**
	 * Language array
	 * @var array
	 *
	 * When updating this, ONLY change the values on the right hand side.
	 * When I push a Prometheus update there will be a new section at the bottom of the en-gb language file each time there's an update.
	 * If the new values are not set it will fallback to the default ones.
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
		"home" => "GĹĂłwna",
		"store" => "Sklep",
		"buy_credits" => "Kup Kredyty",
		"raffles" => "Loterie",
		"profile" => "Profil",
		"support" => "Pomoc",
		"admin" => "Admin",
		"sign_out" => "Wyloguj",
		"sign_in" => "Zaloguj",

		// Header errors and messages
		"not_setup" => "Panel nie zostaĹ poprawnie skonfigurowany! <a href='admin.php?a=gen&p=settings'>Kliknij Tutaj</a> [Admin -> General Settings -> Settings]",
		"header_sandbox" => "PayPal Sandbox jest wĹÄczony. UĹźywaj tylko do testĂłw! MoĹźesz go wyĹÄczyÄ <a href='admin.php?a=gen&p=paypal'>tutaj</a>",
		"missing_action" => "Co najmniej jedna paczka nie ma przypisanej akcji!",
		"unfinished_action" => "Masz nieukoĹczonÄ akcjÄ w 'Profil' , <a href='profile.php'>tutaj</a>",

		// Frontpage
		"welcome" => "Witaj - Zaloguj",
		"welcome_text" => "Zaloguj siÄ za pomocÄ Steam Ĺźeby skorzystaÄ z serwisu.",

		// News
		"news" => "Newsy",
		"by" => "Przez",
		"no_news" => "Brak NewsĂłw",
		"no_news_text" => "Aktualnie nie ma newsĂłw.",
		"no_news_articles" => "Brak nowych artykuĹĂłw.",

		// Footer
		"tos" => "Regulamin Serwisu",
		"powered_by" => "Wspomagany przez Steam",

		// Store
		"credits" => "Kredyty",
		"featured_pkg" => "WyrĂłĹźnione Paczki",
		"permanent" => "Permanentny",
		"non_permanent" => "Niepermanentny",

		"select_credit" => "Wybierz PaczkÄ za Kredyty",
		"select_raffle" => "Wybierz PaczkÄ z Loterii",
		"global_packages" => "Paczki Globalne",

		// Raffles
		"raffle_ticket" => "Kup los",
		"raffle_ended" => "Loteria siÄ zakoĹczyĹa, zwyciÄzcÄ jest: ",
		"raffle_not_compatible" => "Ta paczka nie jest kompatybilna z twojÄ. WejĹcie do loterii odrzucone.",
		"raffle_already_own" => "JuĹź masz tÄ paczkÄ. WejĹcie do loterii odrzucone.",
		"raffle_reached_max" => "OsiÄgnÄĹeĹ maksymalnÄ iloĹÄ wejĹÄ do loterii. WejĹcie do loterii odrzucone.",

		// Support
		"create_ticket" => "UtwĂłrz ZgĹoszenie",
		"ticket_closed" => "ZgĹoszenie jest zamkniÄte.",
		"reply" => "Odpowiedz",
		"create" => "StwĂłrz",

		// Terms of Service
		"tos_edited" => "Regulamin zostaĹ zmieniony. Zaakceptuj <a href='tos.php'>Regulamin Serwisu</a> przed kupnem paczki!",
		"tos_must_accept" => "Musisz zaakceptowaÄ Regulamin przed zakupem!",
		"tos_accept" => "Zgadzam siÄ",

		// Purchase buttons
		"purchase_paypal" => "Kup przez Paypal",
		"purchase_credits" => "Kup przez Kredyty",
		"purchase" => "Kup",
		"buy_sign_in" => "Musisz siÄ zalogowaÄ przed kupnem!",
		"buy_already_own" => "JuĹź masz tÄ paczkÄ!",
		"buy_not_compatible" => "Ta paczka nie jest kompatybilna z paczkÄ ktĂłrÄ posiadasz!",
		"buy_they_already_own" => "Ta osoba juĹź posiada tÄ paczkÄ!",
		"buy_they_not_compatible" => "Ta paczka nie jest kompatybilna z paczkÄ ktĂłrÄ posiada!",

		// Packages
		"buying_someone_else" => "Kupujesz dla innej osoby?",
		"buying_yourself" => "Aktualnie kupujesz dla siebie",
		"buying_for" => "Aktualnie kupujesz dla",
		"packages_custom_amount" => "Dowolna kwota",

		"packages_not_available" => "Brak dostÄpnych paczek dla tego serwera.",
		"raffle_not_available" => "Aktualnie brak dostÄpnych loterii.",
		"credit_not_available" => "Aktualnie brak dostÄpnych kredytĂłw.",

		// Buttons
		"submit" => "WyĹlij",

		// Profile
		"non_perm_pkg" => "Niepermanentne paczki",
		"perm_pkg" => "Permanentne paczki",
		"acc_info" => "Informacje o Koncie",
		"pkg_history" => "Historia Paczek",
		"acc_credits" => "Kredyty",
		"transfer_credits" => "Przelew KredytĂłw",
		"package" => "Paczka",

		// Tables
		"id" => "ID",
		"user" => "UĹźytkownik",
		"description" => "Opis",
		"timestamp" => "Czas",
		"action" => "Akcja",
		"replies" => "Odpowiedzi",
		"view" => "Zobacz",

		// Select boxes
		"select_server" => "Wybierz serwer:",
		"select_currency" => "Wybierz walutÄ:",
		"select_category" => "Wybierz kategoriÄ:",
		"none" => "Brak",

		// Modals
		"yes" => "Tak",
		"no" => "Nie",
		"sure" => "JesteĹ pewien",
		"sure_cur" => "Na pewno chcesz usunÄÄ tÄ walutÄ?",
		"sure_srv" => "Na pewno chcesz usunÄÄ ten serwer?",
		"sure_cat" => "Na pewno chcesz usunÄÄ tÄ kategorie?",

		// Dangerous settings --$
		"dangerous" => "Niebezpieczne Ustawienia",
		"danger_cur" => "Ewentualnie moĹźesz usunÄÄ tÄ walutÄ.",
		"danger_srv" => "Nie usuwaj tego serwera dopĂłki sÄ do niego przypisane paczki!",
		"danger_cat" => "Nie usuwaj tej kategorii dopĂłki sÄ do niej przypisane paczki!",
		"delete" => "UsuĹ",

		// Admin nav
		"dashboard" => "Panel",
		"general_settings" => "GĹĂłwne Ustawienia",
		"support_tickets" => "ZgĹoszenia Pomocy",
		"servers" => "Serwery",
		"currencies" => "Waluty",
		"categories" => "Kategorie",
		"packages_and_actions" => "Paczki i akcje",
		"credit_packages" => "Paczki za Kredyty",
		"raffles" => "Loterie",
		"theme_editor" => "Edytor stylu",
		"documentation" => "Dokumentacja",

		// General Settings
		"settings" => "Ustawienia",
		"main_page" => "Strona GĹĂłwna",
		"integration_settings" => "Ustawienia integracji",
		"ingame_notifications" => "Powiadomienia w grze",

		// Servers page
		"add_srv" => "Dodaj serwer",
		"edit_srv" => "Edytuj serwer",
		"server_name" => "Nazwa serwera",
		"featured_pkg_short" => "WyrĂłĹźnione paczki",

		// Currency page
		"add_cur" => "Dodaj walutÄ",
		"edit_cur" => "Edytuj walutÄ",
		"cc" => "Symbol waluty",

		// Category page
		"add_cat" => "Dodaj kategoriÄ",
		"edit_cat" => "Edytuj kategoriÄ",
		"cat_name" => "Nazwa kategorii",

		// Dashboard nav
		"main_dashboard" => "GĹĂłwny panel",
		"sale" => "WyprzedaĹź",
		"transactions" => "Transakcje",
		"users" => "UĹźytkownicy",
		"logs" => "Logi",
		"update_sql" => "Aktualizacja SQL",
		"other_features" => "Inne wĹaĹciwoĹci",

		// Admin dashboard
		"total" => "W sumie",
		"full_total" => "CaĹkowicie",
		"dashboard_text" => "Witaj w panelu administratora, tutaj moĹźesz zobaczyÄ statystyki swoich serwerĂłw i dotacji.",

		/** 
		 * New in 1.4.7.2
		 */
		"welcome_main" => "Witaj",
		"need_credits" => "Brak KredytĂłw? <a href='store.php?page=credits'>Kliknij tutaj!</a>",
		"no_history" => "Brak historii",
		"amount" => "Kwota",
		"you_have_none" => "Nie masz Ĺźadnej!",

		"add_cre" => "Dodaj paczkÄ za Kredyty",
		"edit_cre" => "Edytuj paczkÄ za Kredyty",
		"pack_title" => "TytuĹ paczki",
		"price" => "Cena",
		"currency" => "Waluta",
		"sure_cre" => "Na pewno chcesz usunÄÄ tÄ paczkÄ?",
		"danger_cre" => "Ewentualnie moĹźesz usunÄÄ tÄ paczkÄ.",
		"select_package" => "Wybierz paczkÄ:",
		"choose_cre" => "Wybierz paczkÄ za kredyty",
		"brief_desc" => "KrĂłtki opis",
		"amt_of_cre" => "IloĹÄ kredytĂłw",
		"price_of_pkg" => "Cena paczki",
		"no_support" => "Nie masz Ĺźadnych zgĹoszeĹ",
		"no_other_available" => "Brak innych paczek",

		/** 
		 * New in 1.4.8
		 */
		"purchase_free" => "ZdobÄdĹş tÄ paczkÄ za darmo!",
		"dashboard_revenuegraph" => "Wykres dochodĂłw",
		"dashboard_revenuecurrency" => "Pokazane w gĹĂłwnej walucie",
		"dashboard_packagesgraph" => "SprzedaĹź Paczek",
		"dashboard_serversgraph" => "SprzedaĹź Serwerowa",
		"between" => "MiÄdzy",
		"and" => "I",

		/** 
		 * New in 1.4.9
		 */
		"free" => "Darmowa",
		"buy_own_free" => "JuĹź posiadasz tÄ darmowÄ paczkÄ, nie moĹźesz mieÄ dwĂłch!",
		
		/**
		 * New in 1.4.9.2
		 */
		"updates" => "Aktualizacje",

		/**
		 * New in 1.4.9.3
		 */
		"header_sqlupdate" => "Masz niewykonanÄ aktualizacjÄ MySQL <a href='admin.php?update'>tutaj!</a>",
		"monthly_goal" => "MiesiÄczny cel",

		/**
		 * New in 1.4.9.6
		 */
		"payment_success" => "PĹatnoĹÄ zakoĹczona sukcesem!",
		"profile_updated" => "TwĂłj profil zostaĹ zaktualizowany.",
		"payment_failed" => "PĹatnoĹÄ zakoĹczona niepowodzeniem!",
		"check_credits" => "SprawdĹş czy masz wystarczajÄcÄ iloĹÄ kredytĂłw do zakupu paczki!",
		"not_authorised" => "Nie moĹźesz byÄ na tej stronie. Zaloguj siÄ najpierw!",

		/**
		 * New in 1.5
		 */
		"wiki" => "Wiki",
		"no_graph_info" => "Brak danych wykresu",
		"no_graph_info_text" => "Brak wykresu przez brak transakcji!",
		"paymentwall_purchase" => "Kup przez Paymentwall",
		"stripe_purchase" => "Kup z Stripe",
		"payment_gateways" => "Metody PĹatnoĹci",
		"advanced" => "Zaawansowane",
		"no_servers" => "Brak serwerĂłw.",
		"entries" => "wejĹcia",
		"you_can_enter" => "MoĹźesz wejĹÄ",
		"times_more" => "wiÄcej razy",
		"dashboard_creditsrevenue" => "Wykres porĂłwnuje wydane kredyty do pieniÄdzy. (Kredyty = <font color='#9c9c9c'><b>Szary</b></font>, PieniÄdze = <font color='#c10000'><b>Czerwony</b></font>)",
		"pkg_discounted" => "Ta paczka jest przeceniona, poniewaĹź posiadasz",

		"compatible_text" => "JeĹli posiadasz tÄ paczkÄ nie moĹźesz kupiÄ Ĺźadnej z poniĹźszych",
		"not_compatible" => "Niekompatybilna z",

		"packages" => "Paczki",
		"upgradeable_text" => "JeĹli posiadasz wybranÄ paczkÄ, dostaniesz zniĹźkÄ na wybrane inne paczki",
		"upgradeable" => "MoĹźliwa do upgrade'u z",

		"assign_actions" => "Dodaj akcje",
		"actions_text" => "Dodaj co ma siÄ staÄ po kupnie paczki przez gracza.",
		"actions" => "Skcje",
		"servers" => "Serwery",
		"label_amount" => "Kwota",
		"add_package" => "Dodaj paczkÄ",
		"edit_package" => "Edytuj paczkÄ",
		"labels" => "Etykiety",
		"title" => "TytuĹ",
		"category" => "Kategoria",
		"no_packages" => "Brak paczek w systemie",

		/**
		 * New in 1.5.0.6
		 */
		"signin" => "Zaloguj",
		"welcome_signin" => "Musisz siÄ zalogowaÄ przed kupnem paczki",
		"blacklist_notext" => "Musisz podaÄ prawidĹowe Steam64 lub SteamID Ĺźeby dodaÄ osobÄ na blacklistÄ!",
		"blacklist_success" => "Dodanie osoby na blacklistÄ zakoĹczone powodzeniem",
		"blacklisted_you" => "Nie masz moĹźliwoĹci kupna Ĺźadnej paczki w tej sieci!",
		"blacklisted_them" => "Ta osoba jest na blackliĹcie, nie moĹźesz kupiÄ dla niej",

		"recent_donators" => "Ostatni darczyĹcy",
		"name" => "Nazwa",
		"recent_none" => "Brak ostatnich darczyĹcĂłw",
		"raffle_free" => "WejdĹş za darmo!",

		/**
		 * New in 1.5.0.8
		 */
		"top_donators" => "Najlepsi darczyĹcy",
		"top_none" => "Brak najlepszych darczyĹcĂłw",

		/**
		 * New in 1.5.0.9
		 */
		"step" => "Krok",

		/**
		 * New in 1.5.1
		 */
		"permission_groups" => "Permisje grupowe",
		"add_permission" => "Dodaj permisje",
		"edit_permission" => "Edytuj permisje",
		"permissions" => "Permisje",
		"no_perm" => "Przykro mi Dave, nie mogÄ Ci na to pozwoliÄ (niewystarczajÄce permisje)",

		/**
		 * New in 1.5.1.2
		 */
		"select_gateway" => "Wybierz metodÄ pĹatnoĹci",

		/**
		 * New in 1.5.2
		 */
		"buy_disable" => "WyĹÄcz paczki",
		"buy_disable_text" => "WyĹÄcz te paczki po zakupie wybranej",

		"credits_doesntexist" => "UĹźytkownik nie istnieje w systemie.",
		"credits_yourself" => "Nie moĹźesz przelaÄ kredytĂłw samemu sobie.",
		"credits_steamid" => "SprĂłbuj innego SteamID",
		"credits_transferringto" => "Przelew do:",

		"type" => "Typ",
		"gateway" => "Metoda",
		"no_users" => "Nie znaleziono uĹźytkownika ",

		"view_profile" => "Zobacz profil",
		"view_blacklist" => "Zobacz blacklistÄ",

		"manage" => "ZarzÄdzaj",
		"users_search" => "Szujkaj nickiem, steam64 albo steamid",

		"transaction" => "Transakcje",
		"delivered" => "Dostarczone",
		"state" => "Status",
		"assign_package" => "Przydziel paczkÄ",
		"set_credits" => "Ustaw kredyty",
		"give_ticket" => "Daj los",
		"del_inactive_actions" => "UsuĹ nieuĹźyte akcje",

		"select_pkg" => "Wybierz paczkÄ",
		"do_assign_actions" => "Przydziel akcje",
		"dont_assign_actions" => "Nie przydzielaj akcji",
		"clone_expiretime" => "Skopiuj czas wygaĹniÄcia takiej samej paczki",
		"assign" => "Przydziel",

		"set" => "Ustaw", 
		"disable" => "WyĹÄcĹź",
		"enable" => "WĹÄcz",
		"inactive_everyone" => "WyĹÄcz wszystkim",
		"del" => "UsuĹ",
		"edit" => "Edytuj",

		"sale_settings" => "Ustawienia przeceny",
		"sale_text" => "Wybierz paczki do przeceny.",
		"message" => "WiadomoĹÄ",
		"percentage" => "Procent",
		"end_date" => "Data zakoĹczenia",

		"update" => "Aktualizacja",
		"automatic_updates" => "Automatyczne aktualizacje",
		"dl_lua" => "Pobierz najnowsze pliki lua",
		"dl_web" => "Pobierz najnowsze pliki web",
		"no_write_perm" => "TwĂłj folder updates nie ma permisji do zapisywania! Automatyczne aktualizacje nie bÄdÄ dziaĹaÄ dopĂłki nie ustawisz chmod 777. <br> MoĹźesz nadal aktualizowaÄ rÄcznie",
		"newest_version" => "Najnowsza dostÄpna wersja to:",

		"test_message" => "WyĹlij wiadomoĹÄ testowÄ na serwer",

		/**
		 * New in 1.5.2.2
		 */
		
		"find_more" => "ZajdĹş wiÄcej!",

		/**
		 * New in 1.5.3
		 */
		
		"duplicate" => "Duplikuj",
		"other" => "Inne",
		"someone_else" => "MoĹźesz kupiÄ dla kogoĹ",

		/**
		 * New in 1.5.4 -- Do not replace $1, $2, $3 etc, they get replaced with numbers and stuff automatically, so keep them there!
		 */
		
		"here" => "tutaj", // This is $1 in 'job_already_created' because it's wrapped in a link
		"job_already_created" => "UtworzyĹeĹ wĹasny 'job'. JeĹli chcesz przejĹÄ do koszyka kliknij $1. W przeciwnym wypadku moĹźesz stworzyÄ nowÄ",
		
		"general_info" => "Informacje OgĂłlne",
		"preferences" => "Preferencje",

		"job_name" => "Nazwa Job",
		"chat_cmd" => "Komenda na wziÄcie job",
		"job_desc" => "Opis job",
		"job_colour" => "Kolor Job",

		"weapons" => "Bronie",
		"models" => "Modele",
		"model" => "Model",
		
		"job_costs" => "Kosztuje $1 or $2 kredytĂłw",

		"friends" => "Znajomi",
		"friends_max" => "<h6>Znajomi - $1 max</h6>",
		"friends_add" => "Dla kaĹźdego znajomego dodaje $1 or $2 kredytĂłw do ceny koĹcowej",
		"friends_not" => "Nie moĹźesz dodaÄ znajomych do tej paczki",

		"salary" => "Zarobki",
		"salary_static" => "TwĂłj zarobek to $1",
		"salary_base" => "TwĂłj podstawowy zarobek to $1. PowiÄkszajÄc iloĹÄ dodajesz $2 or $3 kredytĂłw do ceny koĹcowej",
		"salary_max" => "<h6>Zarobki - $1 razy do powiÄkszenia</h6>",
		"salary_current" => "Twoje obecne zarobki to: $1",
		"license" => "Licencja",
		"license_included" => "ZdobÄdĹş licencjÄ powiÄzanÄ z job",
		"license_include" => "Dodaj licencjÄ - Kosztuje $1 or $2 kredytĂłw",
		"license_no" => "Nie otrzymasz licencji",

		"payment_confirmation" => "Potwierdzenie pĹatnoĹci",
		"job_total" => "Twoja suma to $1 or $2 kredytĂłw",
		"job_proceed" => "PrzejdĹş do koszyka",

		/**
		 * New in 1.5.5
		 */
		
		"job_total_nocredits" => "Twoja suma to $1",
		"job_total_onlycredits" => "Twoja suma kredytĂłw to $1",
		
		"earned_total" => "W SUMIE ZAROBIONE",
		"earned_week" => "ZAROBIONE W TYM TYGODNIU",
		"earned_month" => "ZAROBIONE W TYM MIESIÄCU",

		"real_transaction" => "Licz jako prawdziwÄ transakcjÄ",
		"not_real_transaction" => "Nie licz jako prawdziwÄ transakcjÄ (Nie bÄdzie dodana do statystyk)",

		/**
		 * New in 1.6
		 */

		"active_everyone" => "Aktywuj wszystkim",
		"buy_others_disabled" => "Kupowanie innym jest wyĹÄczone",
		"job_skip_prize" => "PomiĹ - Kliknij tylko jeĹli nie chcesz przyjÄÄ nagrody z loterii",

		"move_packages" => "Kliknij $1 Ĺźeby przenieĹÄ paczki",

		"add" => "Dodaj",
		"edit" => "Edytuj",

		// Theme
		"theme" => "Styl",
		"danger_theme" => "Nie usuwaj stylu dopĂłki go uĹźywasz!",
		"sure_theme" => "Na pewno chcesz usunÄÄ ten styl?",
		"theme_name" => "Nazwa stylu",
		
		"edit_theme" => "Edytuj styl",
		"add_theme" => "Dodaj styl",
		"select_theme" => "Wybierz styl",

		// Imprint page
		"imprint" => "Informacje o SprzedajÄcym",
		"enable_imprint" => "WĹÄcz informacje o sprzedajÄcym",
		"company_name" => "Nazwa firmy",
		"street_address" => "Adres",
		"post_address" => "Adres poczty",
		"country" => "PaĹstwo",
		"trade_register" => "Rodzaj firmy",
		"company_id" => "NIP",
		"company_ceo" => "WĹaĹciciel",
		"contact_email" => "Email kontaktowy",
		"contact_phone" => "Telefon kontaktowy",

		/**
		 * New in 1.6.1
		 */
		"game" => "Gra",
		"server_ip" => "IP serwera",
		"server_port" => "Port serwera",
		"server_rcon" => "RCon serwera",

		"edit_raffle" => "Edytuj loteriÄ",
		"add_raffle" => "Dodaj loteriÄ",
		"select_raffle" => "Wybierz loteriÄ:",

		"package_cantbuy" => "Nie moĹźesz kupiÄ tej paczki bez posiadania: $1",
		"package_they_cantbuy" => "On nie moĹźe kupiÄ tej paczki bez posiadania: $1",

		"hide" => "JeĹli nie masz Ĺźadnej z tych paczek, nie moĹźesz dostaÄ tej",
		"hide_text" => "JeĹli nie masz Ĺźadnej z paczek poniĹźej nie moĹźesz kupiÄ tej",

		"your_spendings" => "Twoje wydatki w 5 ostatnich miesiÄcach",
		"spendings_currency" => "Te wydatki sÄ pokazane w gĹĂłnej walucie [$1]. Wykres porĂłwnuje wydane kredyty do pieniÄdzy. (Kredyty = <font color='#9c9c9c'><b>Szary</b></font>, PieniÄdze = <font color='#c10000'><b>Czerwony</b></font>)",
	
		"spent_total" => "CAĹKOWITE WYDATKI",
		"spent_week" => "WYDATKI W TYM TYGODNIU",
		"spent_month" => "WYDATKI W TYM MIESIÄCU",

		/**
		 * New in 1.6.1.5
		 */
		"advent_calendar" => "Kalendarz Adwentowy",
		"advent" => "Adwent",
		"day" => "DzieĹ",
		"advent_opened" => "OtworzyĹeĹ dzieĹ $1 i otrzymaĹeĹ $2!",
		"advent_nopkg" => "Ten dzieĹ nie ma przypisanej nagrody, zgĹoĹ to administratorowi",
		"advent_text" => "ZdobÄdĹş darmowÄ paczkÄ codziennie od 1. Grudnia do Wigilli, czyli 24.!",

		/**
		 * New in 1.6.2
		 */
		"coupons" => "Kupony",
		"add_cou" => "Dodaj kupon",
		"edit_cou" => "Edytuj kupon",
		"select_cou" => "Wybierz kupon",
		"sure_cou" => "Na pewno chcesz usunÄÄ ten kupon?",
		"coupon_text" => "JeĹli masz kupon moĹźesz go wpisaÄ tu :)",

	);

	$curfile = __FILE__;
	if($curfile == 'pl.php'){
		$english_lang = $lang;
	}

?>
