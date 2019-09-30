var SiteRunningTime = function(config)
{
	var node = document.createElement("span");
	node.innerHTML = config.startTimeText;
	node.className = "SiteRunningTime";
	document.getElementById("footer").appendChild(node);

	var _selector = function(selector)
	{
		return document.querySelector(selector);
	}
	var refreshTime = function(startTime)
	{
		//fix bug#2 在ios中使用时间戳加减使用 Data.parse()转换
		var s1 = Date.parse(startTime.replace(/-/g, "/")),
		s2 = new Date(),
		runTime = parseInt((s2.getTime() - s1) / 1000);

		var year = month = day = hour = minute = second = 0;
		
		year = Math.floor(runTime / 86400 / 365);
		runTime = runTime % (86400 * 365);
		month = Math.floor(runTime / 86400 / 30);
		runTime = runTime % (86400 * 30);
		day = Math.floor(runTime / 86400);
		runTime = runTime % 86400;
		hour = Math.floor(runTime / 3600);
		runTime = runTime % 3600;
		minute = Math.floor(runTime / 60);
		runTime = runTime % 60;
		second = runTime;

		var _year = _month = _day = _hour = _minute = _second = null;
		if((_year = _selector(".SiteRunningTime > .year")) != null) _year.innerText = year;
		if((_month = _selector(".SiteRunningTime > .month")) != null) _month.innerText = month;
		if((_day = _selector(".SiteRunningTime > .day")) != null) _day.innerText = day;
		if((_hour = _selector(".SiteRunningTime > .hour")) != null) _hour.innerText = hour;
		if((_minute = _selector(".SiteRunningTime > .minute")) != null) _minute.innerText = minute;
		if((_second = _selector(".SiteRunningTime > .second")) != null) _second.innerText = second;
	};
	if(config.autoRefresh == "1")
	{
		setInterval(function()
			{
				refreshTime.call(null,config.startTime);
			}, 1000);
	}
	refreshTime(config.startTime);
};
