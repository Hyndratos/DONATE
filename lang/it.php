<?php
	
	/**
	 * Language array
	 * @var array
	 *
	 * When updating this, ONLY change the values on the right hand side.
	 * When I push a Prometheus update there will be a new section at the bottom of the en-gb language file each time there's an update.
	 * If the new values are not set it will fallback to the default ones.
	 *
	 * Italian translation courtesy of Master.
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
		"home" => "Home",
		"store" => "Negozio",
		"buy_credits" => "Compra Crediti",
		"raffles" => "Lotterie",
		"profile" => "Profilo",
		"support" => "Supporto",
		"admin" => "Admin",
		"sign_out" => "Esci",
		"sign_in" => "Accedi",

		// Header errors and messages
		"not_setup" => "Non hai settato il tuo pannello correttamente! <a href='admin.php?a=gen&p=settings'>Clicca qui</a> [Admin -> Impostazioni Generali -> Impostazioni]",
		"header_sandbox" => "PayPal Sandbox è abilitato. Utilizza la Sandbox solo per fare delle prove! Puoi disabilitarlo <a href='admin.php?a=gen&p=paypal'>qui</a>",
		"missing_action" => "Uno o più pacchetti manca un'azione!",
		"unfinished_action" => "Hai un'azione non completata nella pagina del 'Profile', <a href='profile.php'>qui</a>",

		// Frontpage
		"welcome" => "Benvenuto - Accedi",
		"welcome_text" => "Accedi tramite Steam per utilizzare il nostro portale di donazioni.",

		// News
		"news" => "News",
		"by" => "Di",
		"no_news" => "Nessuna news",
		"no_news_text" => "Non ci sono news.",
		"no_news_articles" => "Nessun articolo di news.",

		// Footer
		"tos" => "Termini di Servizio",
		"powered_by" => "Powered by Steam",

		// Store
		"credits" => "Crediti",
		"featured_pkg" => "Pacchetto in primo piano",
		"permanent" => "Permanente",
		"non_permanent" => "Temporaneo",

		"select_credit" => "Seleziona Pacchetto di credito ",
		"select_raffle" => "Seleziona Pacchetto Lotteria",
		"global_packages" => "Pacchetti Globali",

		// Raffles
		"raffle_ticket" => "Compra Ticket",
		"raffle_ended" => "La lotteria è finita, il vincitore è: ",
		"raffle_not_compatible" => "Questo pacchetto non è compatibile con quello che già possiedi. Ingresso alla lotteria negato.",
		"raffle_already_own" => "Possiedi già questo pacchetto. Ingresso alla lotteria negato.",
		"raffle_reached_max" => "Hai raggiunto il massimo importo di entries per la lotteria. Ingresso alla lotteria negato.",

		// Support
		"create_ticket" => "Crea un Ticket",
		"ticket_closed" => "Questo ticket è chiuso.",
		"reply" => "Rispondi",
		"create" => "Crea",

		// Terms of Service
		"tos_edited" => "I Termini sono stati modificati. <a href='tos.php'>Termini di Servizio</a> accettali prima di comprare un pacchetto!",
		"tos_must_accept" => "Devi accettare i Termini prima di poter comprare!",
		"tos_accept" => "Accetta",

		// Purchase buttons
		"purchase_paypal" => "Compra con Paypal",
		"purchase_credits" => "Compra con i Crediti",
		"purchase" => "Compra",
		"buy_sign_in" => "Devi prima Accedere per poter comprare!",
		"buy_already_own" => "Già possiedi questo pacchetto!",
		"buy_not_compatible" => "Questo pacchetto non è compatibile con quello che già possiedi!",
		"buy_they_already_own" => "Questa persona già possiede questo pacchetto!",
		"buy_they_not_compatible" => "Questo pacchetto non è compatibile con quello che già possiede!",

		// Packages
		"buying_someone_else" => "Stai comprando per qualcun altro?",
		"buying_yourself" => "Stai comprando per te stesso",
		"buying_for" => "Stai comprando per",
		"packages_custom_amount" => "Importo personalizzato",

		"packages_not_available" => "Nessun pacchetto disponibile per questo server.",
		"raffle_not_available" => "Nessun pacchetto lotteria disponibile in questo momento.",
		"credit_not_available" => "Nessun pacchetto credito disponibile in questo momento.",

		// Buttons
		"submit" => "Conferma",

		// Profile
		"non_perm_pkg" => "Pacchetto Temporaneo",
		"perm_pkg" => "Pacchetto(i) Permanente",
		"acc_info" => "Informazioni Account",
		"pkg_history" => "Cronologia Pacchetti",
		"acc_credits" => "Crediti",
		"transfer_credits" => "Trasferisci crediti",
		"package" => "Pacchetto",

		// Tables
		"id" => "ID",
		"user" => "Utente",
		"description" => "Descrizione",
		"timestamp" => "Timestamp",
		"action" => "Azione",
		"replies" => "Risposte",
		"view" => "Visualizza",

		// Select boxes
		"select_server" => "Seleziona server:",
		"select_currency" => "Seleziona valuta:",
		"select_category" => "Seleziona categoria:",
		"none" => "Nessuno",

		// Modals
		"yes" => "Si",
		"no" => "No",
		"sure" => "Sei sicuro?",
		"sure_cur" => "Sei sicuro di voler eliminare questa valuta?",
		"sure_srv" => "Sei sicuro di voler eliminare questo server?",
		"sure_cat" => "Sei sicuro di voler eliminare questa categoria?",

		// Dangerous settings
		"dangerous" => "Impostazioni pericolose",
		"danger_cur" => "O in alternativa, puoi eliminare questa valuta.",
		"danger_srv" => "Non eliminare questo server a meno che non ci siano pacchetti assegnati ad esso!",
		"danger_cat" => "Non eliminare questa categoria a meno che non ci siano pacchetti assegnati ad essa!",
		"delete" => "Elimina",

		// Admin nav
		"dashboard" => "Scrivani",
		"general_settings" => "Impostazioni generali",
		"support_tickets" => "Supporto tickets",
		"servers" => "Servers",
		"currencies" => "Valute",
		"categories" => "Categorie",
		"packages_and_actions" => "Pacchetti & Azioni",
		"credit_packages" => "Pacchetti credito",
		"raffles" => "Lotterie",
		"theme_editor" => "Editore Tema",
		"documentation" => "Documentazione",

		// General Settings
		"settings" => "Impostazioni",
		"main_page" => "Pagina Principale",
		"integration_settings" => "Impostazioni di Integrazioni",
		"ingame_notifications" => "Notifiche di Gioco",

		// Servers page
		"add_srv" => "Aggiungi server",
		"edit_srv" => "Modifica server",
		"server_name" => "Nome del Server",
		"featured_pkg_short" => "Pacchetto in primo piano",

		// Currency page
		"add_cur" => "Aggiungi valuta",
		"edit_cur" => "Modifica valuta",
		"cc" => "Codice valuta",

		// Category page
		"add_cat" => "Aggiungi categoria",
		"edit_cat" => "Modifica categoria",
		"cat_name" => "Nome categoria",

		// Dashboard nav
		"main_dashboard" => "Scrivania Principale",
		"sale" => "Vendita",
		"transactions" => "Transazioni",
		"users" => "Utenti",
		"logs" => "Logs",
		"update_sql" => "Aggiorna SQL",
		"other_features" => "Altre funzioni",

		// Admin dashboard
		"total" => "Totale",
		"full_total" => "Totale completo",
		"dashboard_text" => "Benvenuto sulla scrivania dell'amministratore, questo è dove sari in grado di visualizzare le statistiche sulla inclinazione delle attività di donazione dei servers.",

		/** 
		 * New in 1.4.7.2
		 */
		"welcome_main" => "Benvenuto",
		"need_credits" => "Hai bisogno di più crediti? <a href='store.php?page=credits'>Clicca qui!</a>",
		"no_history" => "Nessuna Cronologia",
		"amount" => "Quantità",
		"you_have_none" => "Non ne hai!",

		"add_cre" => "Aggiungi pacchetto credito",
		"edit_cre" => "Modifica pacchetto credito",
		"pack_title" => "Titolo del Pacchetto",
		"price" => "Prezzo",
		"currency" => "Valuta",
		"sure_cre" => "Sei sicuro di voler eliminare questo pacchetto credito?",
		"danger_cre" => "O in alternativa, puoi eliminare questo pacchetto credito.",
		"select_package" => "Seleziona pacchetto:",
		"choose_cre" => "Scegli pacchetto credito",
		"brief_desc" => "Breve descrizione",
		"amt_of_cre" => "Quantità credito",
		"price_of_pkg" => "Prezzo del pacchetto",
		"no_support" => "Non hai nessun support tickets",
		"no_other_available" => "Nessun altro pacchetto disponibile",

		/** 
		 * New in 1.4.8
		 */
		"purchase_free" => "Ottieni questo pacchetto gratuitamente!",
		"dashboard_revenuegraph" => "Grafico Entrate",
		"dashboard_revenuecurrency" => "Indicato nella tua valuta principale",
		"dashboard_packagesgraph" => "Vendita Pacchetti",
		"dashboard_serversgraph" => "Vendita Servers",
		"between" => "Tra",
		"and" => "E",

		/** 
		 * New in 1.4.9
		 */
		"free" => "Gratuito",
		"buy_own_free" => "Già possiedi questo pacchetto gratuito. Non puoi ottenerlo per la seconda volta!",
		
		/**
		 * New in 1.4.9.2
		 */
		"updates" => "Aggiornamenti",

		/**
		 * New in 1.4.9.3
		 */
		"header_sqlupdate" => "Hai un aggiornamento MySQL <a href='admin.php?update'>qui!</a>",
		"monthly_goal" => "Obiettivo mensile",

		/**
		 * New in 1.4.9.6
		 */
		"payment_success" => "Pagamento avvenuto con Successo!",
		"profile_updated" => "Il tuo profilo è stato aggiornato.",
		"payment_failed" => "Pagamento Fallito!",
		"check_credits" => "Perfavore controlla se hai abbastanza crediti per comprare questo pacchetto!",
		"not_authorised" => "Non sei autorizzato a vedere quest'area. Devi accedere prima!",

		/**
		 * New in 1.5
		 */
		"wiki" => "Wiki",
		"no_graph_info" => "Nessun infromazione grafico",
		"no_graph_info_text" => "Nessun informazione grafico, non ci sono state transazioni!",
		"paymentwall_purchase" => "Compra con Paymentwall",
		"stripe_purchase" => "Compra con Stripe",
		"payment_gateways" => "Metodi di Pagamento",
		"advanced" => "Avanzate",
		"no_servers" => "Nessun server disponibile in questo momento.",
		"entries" => "entries",
		"you_can_enter" => "Puoi partecipare",
		"times_more" => "time(s) more",
		"dashboard_creditsrevenue" => "Questo grafico mette a confronto anche i crediti spesi per i soldi spesi. Anche se i crediti possono essere acquisiti con i soldi. (Crediti = <font color='#9c9c9c'><b>Grigio</b></font>, Denaro = <font color='#c10000'><b>Rosso</b></font>)",
		"pkg_discounted" => "Questo pacchetto è scontato perché lo possiedi",

		"compatible_text" => "Se possiedi questo pacchetto, non è possibile ottenere i pacchetti selezionati di seguito",
		"not_compatible" => "Non compatibile con",

		"packages" => "Pacchetti",
		"upgradeable_text" => "Se possiedi il pacchetto selezionato , otterai questo ad un prezzo scontato del prezzo dei pacchetti selezionati",
		"upgradeable" => "Aggiornabile con",

		"assign_actions" => "Azioni assegnate",
		"actions_text" => "Assegna qualsiasi azione che tu voglia a questo pacchetto da eseguire dopo che è stato acquistato da un giocatore.",
		"actions" => "Azioni",
		"servers" => "Servers",
		"label_amount" => "Quota Etichetta",
		"add_package" => "Aggiungi pacchetto",
		"edit_package" => "Modifica pacchetto",
		"labels" => "Etichette",
		"title" => "Titolo",
		"category" => "Categoria",
		"no_packages" => "Non hai pacchetti nel sistema",

		/**
		 * New in 1.5.0.6
		 */
		"signin" => "Accedi",
		"welcome_signin" => "Devi prima Accedere per poter comprare un pacchetto!",
		"blacklist_notext" => "È necessario immettere un Steam64 o SteamID valido da mettere in blacklist!",
		"blacklist_success" => "Hai blacklistato questa persona con successo!",
		"blacklisted_you" => "Sei stato blacklistato, non puoi comprare nessun pacchetto!",
		"blacklisted_them" => "Questa persona è stata blacklistata, non puoi comprargli nessun pacchetto!",

		"recent_donators" => "Donatori Recenti",
		"name" => "Nome",
		"recent_none" => "Non ci sono Donatori Recenti",
		"raffle_free" => "Entra gratuitamente!",

		/**
		 * New in 1.5.0.8
		 */
		"top_donators" => "Top donatori",
		"top_none" => "Non ci sono Top donatori",

		/**
		 * New in 1.5.0.9
		 */
		"step" => "Step",

		/**
		 * New in 1.5.1
		 */
		"permission_groups" => "Permessi gruppi",
		"add_permission" => "Aggiungi permesso gruppo",
		"edit_permission" => "Modifica permesso gruppo",
		"permissions" => "Permessi",
		"no_perm" => "Mi di spiace amico, non posso lasciartelo fare (Permessi insufficienti)",

		/**
		 * New in 1.5.1.2
		 */
		"select_gateway" => "Seleziona metodo di pagamento",

		/**
		 * New in 1.5.2
		 */
		"buy_disable" => "Disabilita pacchetto",
		"buy_disable_text" => "Disabilita il pacchetto",

		"credits_doesntexist" => "Questo utente non esiste nel sistema.",
		"credits_yourself" => "Non puoi trasferire crediti a te stesso.",
		"credits_steamid" => "Prova un altro SteamID",
		"credits_transferringto" => "Transferisci a:",

		"type" => "Digita",
		"gateway" => "Gateway",
		"no_users" => "Nessuno utente trovato",

		"view_profile" => "Visualizza Profilo",
		"view_blacklist" => "Visualizza Blacklist",

		"manage" => "Gestisci",
		"users_search" => "Cerca per nome, steam64 o steamid",

		"transaction" => "Transazione",
		"delivered" => "Consegnato",
		"state" => "Stato",
		"assign_package" => "Assegna pacchetto",
		"set_credits" => "Imposta crediti",
		"give_ticket" => "Manda ticket",
		"del_inactive_actions" => "Elimina azioni inattive",

		"select_pkg" => "Seleziona pacchetto",
		"do_assign_actions" => "Assegna azione",
		"dont_assign_actions" => "Non assegnare azioni",
		"clone_expiretime" => "Clona la stessa scadenza dell'ultimo pacchetto",
		"assign" => "Assegna",

		"set" => "Imposta", 
		"disable" => "Disabilita",
		"enable" => "Abilita",
		"inactive_everyone" => "Imposta tutti come inattivo",
		"del" => "Eli",
		"edit" => "Modif",

		"sale_settings" => "Impostazioni Vendita",
		"sale_text" => "Scegli quali pacchetti desideri che la vendita venga applicata.",
		"message" => "Messaggio",
		"percentage" => "Percentuale",
		"end_date" => "Data di fine",

		"update" => "Aggiornamento",
		"automatic_updates" => "Aggiornamenti automatici",
		"dl_lua" => "Scarica l'ultimo lua",
		"dl_web" => "Scarica l'ultimo web",
		"no_write_perm" => "La cartella per gli aggiornamenti non ha i permessi per scrivere! Gli Aggiornamenti automatici non funzioneranno fino a quando non verranno impostato il permesso alla cartella 777. <br> Puoi in ogni caso utilizzare questo pulsante per scaricare manualmente gli aggiornamenti.",
		"newest_version" => "La versione più aggiornata è:",

		"test_message" => "Manda messaggio al server",

		/**
		 * New in 1.5.2.2
		 */
		
		"find_more" => "Scopri di più",

		/**
		 * New in 1.5.3
		 */
		
		"duplicate" => "Duplica",
		"other" => "Altro",
		"someone_else" => "Puoi comunque sia comprarlo per qualcun altro",

		/**
		 * New in 1.5.4 -- Do not replace $1, $2, $3 etc, they get replaced with numbers and stuff automatically, so keep them there!
		 */
		
		"here" => "qui", // This is $1 in 'job_already_created' because it's wrapped in a link
		"job_already_created" => "Hai già creato un lavoro personalizzato. Se vuoi proseguire clicca su $1. In caso contrario puoi crearne uno nuovo",
		
		"general_info" => "Informazioni Generali",
		"preferences" => "Preferenze",

		"job_name" => "Nome Lavoro",
		"chat_cmd" => "Utilizza il comando chat per avere questo lavoro",
		"job_desc" => "Descrizione Lavoro",
		"job_colour" => "Colore Lavoro",

		"weapons" => "Armi",
		"models" => "Modelli",
		"model" => "Modello",
		
		"job_costs" => "Costi $1 o $2 crediti",

		"friends" => "Amici",
		"friends_max" => "<h6>Amici - $1 massimo</h6>",
		"friends_add" => "Ogni amico che aggiungi ti aggiunge $1 o $2 crediti al prezzo finale",
		"friends_not" => "Non sei autorizzato ad aggiunger amici su questo pacchetto",

		"salary" => "Stipendio",
		"salary_static" => "Il tuo stipendio sarà $1",
		"salary_base" => "Lo stipendio base è $1.Per ogni numero ti aggiunge $2 r $3 crediti al prezzo finale",
		"salary_max" => "<h6>Stipendio - $1 massimo da scalare</h6>",
		"salary_current" => "Il tuo stipendio attuale è: $1",

		"license" => "Licenza",
		"license_included" => "E' possibile ottenere una licenza incluso nel lavoro",
		"license_include" => "Includere una licenza - Costa $1 o $2 crediti",
		"license_no" => "Non hai ottenuto una licenza",

		"payment_confirmation" => "Conferma Pagamento",
		"job_total" => "Il totale è di $1 o $2 crediti",
		"job_proceed" => "Procedere al Checkout",

		/**
		 * New in 1.5.5
		 */
		
		"job_total_nocredits" => "Il tuo totale è di $1",
		"job_total_onlycredits" => "Il tuo totale è di $1 crediti",
		
		"earned_total" => "TOTALE GUADAGNATO",
		"earned_week" => "GUADAGNO DELLA SETTIMANA",
		"earned_month" => "GUADAGNO DEL MESE",

		"real_transaction" => "Conta come una vera e propria transazione",
		"not_real_transaction" => "Non contare come una vera e propria transazione (Non aggiungerà denaro per eventuali statistiche)",

		/**
		 * New in 1.6
		 */

		"active_everyone" => "Imposta attivo per tutti",
		"buy_others_disabled" => "Comprare per qualcun altro è disabilitato in questo sistema",
		"job_skip_prize" => "Salta - Clicca questo se non desideri ricevere il premio della lotteria",

		"move_packages" => "Clicca $1 per muoverti tra i pacchetti",

		"add" => "Aggiungi",
		"edit" => "Modifica",

		// Theme
		"theme" => "Tema",
		"danger_theme" => "Non eliminare questo tema fino a quando non lo utilizzi!",
		"sure_theme" => "Sei sicuro di voler eliminare questo tema?",
		"theme_name" => "Nome del Tema",
		
		"edit_theme" => "Modifica Tema",
		"add_theme" => "Aggiungi Tema",
		"select_theme" => "Seleziona tema",

		// Imprint page
		"imprint" => "Stampa",
		"enable_imprint" => "Abilita stampa",
		"company_name" => "Nome della ditta",
		"street_address" => "Indirizzo",
		"post_address" => "CAP",
		"country" => "Città",
		"trade_register" => "Registro imprese",
		"company_id" => "Partita IVA",
		"company_ceo" => "CEO",
		"contact_email" => "Email",
		"contact_phone" => "Telefono",

		/**
		 * New in 1.6.1
		 */
		"game" => "Gioco",
		"server_ip" => "Server IP",
		"server_port" => "Server port",
		"server_rcon" => "Server RCon",

		"edit_raffle" => "Modifica lotteria",
		"add_raffle" => "Aggiungi lotteria",
		"select_raffle" => "Seleziona lotteria:",

		"package_cantbuy" => "Non è possibile acquistare il pacchetto senza possedere uno dei seguenti modi: $1",
		"package_they_cantbuy" => "Non possono acquistare questo pacchetto senza possedere uno dei seguenti: $1",

		"hide" => "Se non possiedi uno di questi pacchetti, non puoi ottenere questo qua",
		"hide_text" => "Se non possiedi uno di questi pacchetti selezionati di seguito, questo pacchetto non può essere acquistato",

		"your_spendings" => "Le tue spese negli ultimi 5 mesi",
		"spendings_currency" => "Queste spese sono mostrate in questo sito con la valuta principale [$1]. Questo grafico mette a confronto i crediti spesi per soldi spesi. Anche se i crediti sono acquisiti con i soldi. (Crediti = <font color='#9c9c9c'><b>Grigio</b></font>, Denaro = <font color='#c10000'><b>Rosso</b></font>)",
	
		"spent_total" => "SPESA TOTALE",
		"spent_week" => "SPESO QUESTA SETTIMANA",
		"spent_month" => "SPESO QUESTO MESE",

		/**
		 * New in 1.6.1.5
		 */
		"advent_calendar" => "Calendario dell'Avvento",
		"advent" => "Avvento",
		"day" => "Giorno",
		"advent_opened" => "You have opened day $1 and received $2!",
		"advent_nopkg" => "Questo giorno non ha pacchetti assegnati, per favore contatta un amministratore della comunity per riferire il problema",
		"advent_text" => "Ottieni un pacchetto gratuito, a partire dal 1° Dicembre fino alla Vigilia di Natale del 24° Dicembre!",

		/**
		 * New in 1.6.2
		 */
		"coupons" => "Coupons",
		"add_cou" => "Aggiungi coupon",
		"edit_cou" => "Modifica coupon",
		"select_cou" => "Seleziona coupon",
		"sure_cou" => "Sei sicuro di volere eliminare questo coupon?",
		"coupon_text" => "Se hai un codice coupon puoi aggiungerlo qui :)",

	);
?>
