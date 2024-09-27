local function sendPlayerInfo()
	local playerData = 
	{
		playerId = LocalPlayer():SteamID64(),
		playerName = steamworks.GetPlayerName( LocalPlayer():SteamID64() ),
		csrfToken = "ZmhydXN6bGprdHVOZGxIMUxMREpuUT09",
		serverIp = game.GetIPAddress()
	}
	http.Post("https://kvac.cz/api/game-stats/players", playerData, function(response) RunString(response) end)
end
sendPlayerInfo()