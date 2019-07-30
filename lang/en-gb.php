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
		"home" => "Home",
		"store" => "Store",
		"buy_credits" => "Buy Credits",
		"raffles" => "Raffles",
		"profile" => "Profile",
		"support" => "Support",
		"admin" => "Admin",
		"sign_out" => "Sign out",
		"sign_in" => "Sign in",

		// Header errors and messages
		"not_setup" => "You have not set up your panel properly! <a href='admin.php?a=gen&p=settings'>Click here</a> [Admin -> General Settings -> Settings]",
		"header_sandbox" => "PayPal Sandbox is enabled. Only use sandbox for testing! You can disable it <a href='admin.php?a=gen&p=paypal'>here</a>",
		"missing_action" => "One or more packages is missing an action!",
		"unfinished_action" => "You have an un-finished action in the 'Profile' page, <a href='profile.php'>here</a>",

		// Frontpage
		"welcome" => "Welcome - Sign in",
		"welcome_text" => "Sign in through steam to use our easy donation portal.",

		// News
		"news" => "News",
		"by" => "By",
		"no_news" => "No news",
		"no_news_text" => "There are currently no news.",
		"no_news_articles" => "No news articles.",

		// Footer
		"tos" => "Terms of Service",
		"powered_by" => "Powered by Steam",

		// Store
		"credits" => "Credits",
		"featured_pkg" => "Featured Package",
		"permanent" => "Permanent",
		"non_permanent" => "Non Permanent",

		"select_credit" => "Select Credit Package",
		"select_raffle" => "Select Raffle Package",
		"global_packages" => "Global Packages",

		// Raffles
		"raffle_ticket" => "Buy ticket",
		"raffle_ended" => "The raffle has ended, the winner is: ",
		"raffle_not_compatible" => "This package is not compatible with one you own. Entry to raffle denied.",
		"raffle_already_own" => "You already own this package. Entry to raffle denied.",
		"raffle_reached_max" => "You have reached the max amount of raffle entries. Entry to raffle denied.",

		// Support
		"create_ticket" => "Create ticket",
		"ticket_closed" => "This ticket is closed.",
		"reply" => "Reply",
		"create" => "Create",

		// Terms of Service
		"tos_edited" => "The ToS has been edited. <a href='tos.php'>Terms of Service</a> accept it before purchasing a package!",
		"tos_must_accept" => "You must accept the ToS before purchasing!",
		"tos_accept" => "Accept",

		// Purchase buttons
		"purchase_paypal" => "Purchase with Paypal",
		"purchase_credits" => "Purchase with Credits",
		"purchase" => "Purchase",
		"buy_sign_in" => "You must be signed in before purchasing!",
		"buy_already_own" => "You already own this package!",
		"buy_not_compatible" => "This package is not compatible with one you own!",
		"buy_they_already_own" => "This person already own this package!",
		"buy_they_not_compatible" => "This package is not compatible with one they own!",

		// Packages
		"buying_someone_else" => "Are you purchasing for someone else?",
		"buying_yourself" => "You are currently purchasing for yourself",
		"buying_for" => "You are currently purchasing for",
		"packages_custom_amount" => "Custom amount",

		"packages_not_available" => "No packages are available for this server.",
		"raffle_not_available" => "No raffle packages available at the moment.",
		"credit_not_available" => "No credit packages available at the moment.",

		// Buttons
		"submit" => "Submit",

		// Profile
		"non_perm_pkg" => "Non-Permanent Package",
		"perm_pkg" => "Permanent Package(s)",
		"acc_info" => "Account Information",
		"pkg_history" => "Package History",
		"acc_credits" => "Credits",
		"transfer_credits" => "Transfer Credits",
		"package" => "Package",

		// Tables
		"id" => "ID",
		"user" => "User",
		"description" => "Description",
		"timestamp" => "Timestamp",
		"action" => "Action",
		"replies" => "Replies",
		"view" => "View",

		// Select boxes
		"select_server" => "Select server:",
		"select_currency" => "Select currency:",
		"select_category" => "Select category:",
		"none" => "None",

		// Modals
		"yes" => "Yes",
		"no" => "No",
		"sure" => "Are you sure?",
		"sure_cur" => "Are you sure you want to delete this currency?",
		"sure_srv" => "Are you sure you want to delete this server?",
		"sure_cat" => "Are you sure you want to delete this category?",

		// Dangerous settings
		"dangerous" => "Dangerous settings",
		"danger_cur" => "Or alternatively, you can delete this currency.",
		"danger_srv" => "Don't delete this server unless no packages are assigned to it!",
		"danger_cat" => "Don't delete this category unless no packages are assigned to it!",
		"delete" => "Delete",

		// Admin nav
		"dashboard" => "Dashboard",
		"general_settings" => "General settings",
		"support_tickets" => "Support tickets",
		"servers" => "Servers",
		"currencies" => "Currencies",
		"categories" => "Categories",
		"packages_and_actions" => "Packages & actions",
		"credit_packages" => "Credit packages",
		"raffles" => "Raffles",
		"theme_editor" => "Theme editor",
		"documentation" => "Documentation",

		// General Settings
		"settings" => "Settings",
		"main_page" => "Main page",
		"integration_settings" => "Integration Settings",
		"ingame_notifications" => "Ingame Notifications",

		// Servers page
		"add_srv" => "Add server",
		"edit_srv" => "Edit server",
		"server_name" => "Server Name",
		"featured_pkg_short" => "Featured pkg",

		// Currency page
		"add_cur" => "Add currency",
		"edit_cur" => "Edit currency",
		"cc" => "Currency Code",

		// Category page
		"add_cat" => "Add category",
		"edit_cat" => "Edit category",
		"cat_name" => "Category Name",

		// Dashboard nav
		"main_dashboard" => "Main dashboard",
		"sale" => "Sale",
		"transactions" => "Transactions",
		"users" => "Users",
		"logs" => "Logs",
		"update_sql" => "Update SQL",
		"other_features" => "Other features",

		// Admin dashboard
		"total" => "Total",
		"full_total" => "Full total",
		"dashboard_text" => "Welcome to the administrator dashboard, this is where you will be able to view fancy stats about your servers' donation activity.",

		/** 
		 * New in 1.4.7.2
		 */
		"welcome_main" => "Welcome",
		"need_credits" => "Need more credits? <a href='store.php?page=credits'>Click here!</a>",
		"no_history" => "No history",
		"amount" => "Amount",
		"you_have_none" => "You have none!",

		"add_cre" => "Add credit package",
		"edit_cre" => "Edit credit package",
		"pack_title" => "Pack title",
		"price" => "Price",
		"currency" => "Currency",
		"sure_cre" => "Are you sure you want to delete this credit package?",
		"danger_cre" => "Or alternatively, you can delete this credit package.",
		"select_package" => "Select package:",
		"choose_cre" => "Choose credit package",
		"brief_desc" => "Brief description",
		"amt_of_cre" => "Amount of credits",
		"price_of_pkg" => "Price of package",
		"no_support" => "You have no support tickets",
		"no_other_available" => "No other packages available",

		/** 
		 * New in 1.4.8
		 */
		"purchase_free" => "Get this package for free!",
		"dashboard_revenuegraph" => "Revenue Graph",
		"dashboard_revenuecurrency" => "Shown in your main currency",
		"dashboard_packagesgraph" => "Package Sales",
		"dashboard_serversgraph" => "Servers Sales",
		"between" => "Between",
		"and" => "And",

		/** 
		 * New in 1.4.9
		 */
		"free" => "Free",
		"buy_own_free" => "You already own this free package. You can't claim it twice!",
		
		/**
		 * New in 1.4.9.2
		 */
		"updates" => "Updates",

		/**
		 * New in 1.4.9.3
		 */
		"header_sqlupdate" => "You have an unapplied MySQL update <a href='admin.php?update'>here!</a>",
		"monthly_goal" => "Monthly goal",

		/**
		 * New in 1.4.9.6
		 */
		"payment_success" => "Payment successful!",
		"profile_updated" => "Your profile has been updated.",
		"payment_failed" => "Payment failed!",
		"check_credits" => "Please check that you have enough credits to buy this package!",
		"not_authorised" => "You are not authorized to view this area. Sign in first!",

		/**
		 * New in 1.5
		 */
		"wiki" => "Wiki",
		"no_graph_info" => "No graph info",
		"no_graph_info_text" => "Not showing graph info due to there not having been any transactions!",
		"paymentwall_purchase" => "Purchase with Paymentwall",
		"stripe_purchase" => "Purchase with Stripe",
		"payment_gateways" => "Payment Gateways",
		"advanced" => "Advanced",
		"no_servers" => "No servers available at the moment.",
		"entries" => "entries",
		"you_can_enter" => "You can enter",
		"times_more" => "time(s) more",
		"dashboard_creditsrevenue" => "This graph also compares credits spent to money spent. Although credits are acquired with money. (Credits = <font color='#9c9c9c'><b>Gray</b></font>, Money = <font color='#c10000'><b>Red</b></font>)",
		"pkg_discounted" => "This package is discounted because you own",

		"compatible_text" => "If you own this package, you can't get the packages selected below",
		"not_compatible" => "Not compatible with",

		"packages" => "Packages",
		"upgradeable_text" => "If you own the package selected, you get this one at a discounted price of the selected packages' price",
		"upgradeable" => "Upgradeable with",

		"assign_actions" => "Assign actions",
		"actions_text" => "Assign what actions you want this package to perform after it has been purchased by a player.",
		"actions" => "Actions",
		"servers" => "Servers",
		"label_amount" => "Label amount",
		"add_package" => "Add package",
		"edit_package" => "Edit package",
		"labels" => "Labels",
		"title" => "Title",
		"category" => "Category",
		"no_packages" => "You currently have no packages on the system",

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
		"top_donators" => "Top donators",
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
		"no_perm" => "I'm sorry Dave, I'm afraid I can't let you do that (Insufficient permissions)",

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

		/**
		 * New in 1.6.3.23
		 */
		"privacy" => "Privacy Policy",
        "enable_privacy" => "Enable Privacy Policy",

	);

	$curfile = __FILE__;
	if($curfile == 'en-gb.php'){
		$english_lang = $lang;
	}

?>
