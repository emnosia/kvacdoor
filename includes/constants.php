<?php
// CONSTANTES KVACDOOR 2019 - 2020

define("WEBSITE_NAME", "KVacDoor");
define("WEBSITE_NAME_U", strtoupper(WEBSITE_NAME));
define("WEBSITE_URL", "https://kvac.cz");
define("WEBSITE_EMAIL", "contact@kvacdoor.cz");
define("WEBSITE_AUTHOR", "WaDixix");
define("WEBSITE_DESCRIPTION", "");


define("LOGIN_PAGE", '/login');
define("CONTROLLER_PATH", "../app/Controllers/");
define("VIEW_PATH", "../templates/manager/");
define("LAYOUT_PATH", "../templates/layouts/");

define("CONTROLLERS", "../app/Controllers/");
define("VIEWS", "../templates/manager/");

define("DATABASE", __DIR__."/config/database.php");

define("CURRENT_PAGE", $_SERVER["REQUEST_URI"]);

define("DISCORD_INVITE", "https://discord.gg/MrJUbQ72kj");
define("DISCORD_GUILD_ID", "700208815249031198");

define("OAUTH2_CLIENT_ID", "628657650942345246");
define("OAUTH2_CLIENT_SECRET", "YMrTalrUAAjOee9YFSIzPOo7qk2MSLUr");
define("OAUTH2_REDIRECT_URL", "https://kvacdoor.cz/auth/callback");
define("OAUTH2_SCOPE", '["identify","guilds"]');

?>