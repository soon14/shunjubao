var host = "http://"+window.location.host;
var urlStr = host + "/www/interface/matchlist.php?s=" + curPos.gameCode + "&p=," + curPos.dataPool;
var selAry = {};
var dAry, min_maxAry, tAry;
var oddsTitle = { 
		had: ["胜", "平", "负"], 
		hhad: ["胜", "平", "负"], 
		ttg: ["0球", "1球", "2球", "3球", "4球", "5球", "6球", "7+球"], 
		hafu: ["胜胜", "胜平", "胜负", "平胜", "平平", "平负", "负胜", "负平", "负负"], 
		crs: ["1:0", "2:0", "2:1", "3:0", "3:1", "3:2", "4:0", "4:1", "4:2", "5:0", "5:1", "5:2", "胜其他", "0:0", "1:1", "2:2", "3:3", "平其他", "0:1", "0:2", "1:2", "0:3", "1:3", "2:3", "0:4", "1:4", "2:4", "0:5", "1:5", "2:5", "负其他"], 
		mnl: ["主负", "主胜"], 
		hdc: ["让分主负", "让分主胜"], 
		hilo: ["大", "小"], 
		wnm: ["客胜1-5", "客胜6-10", "客胜11-15", "客胜16-20", "客胜21-25", "客胜26+", "主胜1-5", "主胜6-10", "主胜11-15", "主胜16-20", "主胜21-25", "主胜26+"] 
};
var oddsCode = {
		had: ["h", "d", "a"], 
		hhad: ["h", "d", "a"], 
		ttg: ["s0", "s1", "s2", "s3", "s4", "s5", "s6", "s7"], 
		hafu: ["hh", "hd", "ha", "dh", "dd", "da", "ah", "ad", "aa"], 
		crs: ["0100", "0200", "0201", "0300", "0301", "0302", "0400", "0401", "0402", "0500", "0501", "0502", "-1-h", "0000", "0101", "0202", "0303", "-1-d", "0001", "0002", "0102", "0003", "0103", "0203", "0004", "0104", "0204", "0005", "0105", "0205", "-1-a"], 
		mnl: ["h", "a"], 
		hdc: ["h", "a"], 
		hilo: ["h", "l"], 
		wnm: ["l1", "l2", "l3", "l4", "l5", "l6", "w1", "w2", "w3", "w4", "w5", "w6"]
};
var oddsIndex = ["胜", "平", "负", "让球胜", "让球平", "让球 负", "1:0", "2:0", "2:1", "3:0", "3:1", "3:2", "4:0", "4:1", "4:2", "5:0", "5:1", "5:2", "胜其他", "0:0", "1:1", "2:2", "3:3", "平其他", "0:1", "0:2", "1:2", "0:3", "1:3", "2:3", "0:4", "1:4", "2:4", "0:5", "1:5", "2:5", "负其他", "胜胜", "胜平", "胜负", "平胜", "平平", "平负", "负胜", "负平", "负负", "0球", "1球", "2球", "3球", "4球", "5球", "6球", "7+球"];
if (curPos.gameCode == "bk") oddsIndex = ["主负", "主胜", "让分主负", "让分主胜", "大", "小", "客胜1-5", "客胜6-10", "客胜11-15", "客胜16-20", "客胜21-25", "客胜26+", "主胜1-5", "主胜6-10", "主胜11-15", "主胜16-20", "主胜21-25", "主胜26+"];
var optionAry = [[], [], [["2串1", "2"]], [["3串1", "3"], ["3串3", "2"], ["3串4", "23"]], [["4串1", "4"], ["4串4", "3"], ["4串5", "34"], ["4串6", "2"], ["4串11", "234"]], [["5串1", "5"], ["5串5", "4"], ["5串6", "45"], ["5串10", "2"], ["5串16", "345"], ["5串20", "23"], ["5串26", "2345"]], [["6串1", "6"], ["6串6", "5"], ["6串7", "56"], ["6串15", "2"], ["6串20", "3"], ["6串22", "456"], ["6串35", "23"], ["6串42", "3456"], ["6串50", "234"], ["6串57", "23456"]], [["7串1", "7"], ["7串7", "6"], ["7串8", "67"], ["7串21", "5"], ["7串35", "4"], ["7串120", "234567"]], [["8串1", "8"], ["8串8", "7"], ["8串9", "87"], ["8串28", "6"], ["8串56", "5"], ["8串70", "4"], ["8串247", "2345678"]]];
var poolOptionIndex = { had: 0, hhad: 3, crs: 6, ttg: 46, hafu: 37, mnl: 0, hdc: 2, hilo: 4, wnm: 6, crosspool: 0 };
var poolOptionCount = { had: 3, hhad: 3, crs: 31, ttg: 8, hafu: 9, mnl: 2, hdc: 2, hilo: 2, wnm: 12 };
var poolIndex = { fb: ["had", "hhad", "crs", "ttg", "hafu" ,"crosspool"], bk: ["mnl", "hdc", "hilo", "wnm","crosspool"] };
//玩法串关数限制：比分crs4；总进球ttg6；版全场hafu4;胜分差wnm4；其他8
var selCountAry = { had: 8, crs: 4, ttg: 6, hafu: 4, mnl: 8, hdc: 8, hilo: 8, wnm: 4 ,crosspool: 4};
$(document).ready(function() {
    //调用数据接口
    $.getScript(urlStr + "&f=getDataBack", null);
    //全删
    $(".clearSel").click(function() {
        clearSel();
        calculate();
        fillOptionsPan();
    });
    //点击选择面板中的已选项
    $("#selPan").delegate("b", "click", function() {
        //从.active中删除
        var key = $(this).closest("ul").attr("key");
        var index = Number($(this).attr("index"));
        if (curPool == "crs") {
            $("#" + key).closest("tr").next().find(".o").eq(index - poolOptionIndex[curPool]).removeClass("active");
        } else if (curPool == "crosspool" && index >= 6) {
            $("#" + key).closest("tr").next().find(".o").eq(index - 6).removeClass("active");
        } else {
            $("#" + key).closest("tr").find(".o").eq(index - poolOptionIndex[curPool]).removeClass("active");
        }
        selAry[key].odds[index] = 1;
        //

        if ($(this).parent().children().length == 1) {
            $(this).closest("ul").remove();
            delete (selAry[key]);
        } else {
            $(this).remove();
            fillOptionsPan();
        }

        selCount();
        fillOptionsPan();
        calculate();
    });
    //定胆
    $("#selPan").delegate("input", "click", function() {
        var key = $(this).closest("ul").attr("key");
        if ($(this).prop("checked")) {
            selAry[key].isDan = true;
        } else {
            selAry[key].isDan = false;
        }
        calculate();
    });
    //删除一行
    $("#selPan").delegate(".Clear>a", "click", function() {
        var key = $(this).closest("ul").attr("key");
        //从selAry中删除
        delete (selAry[key]);
        //从.active中删除
        if (curPool == "crosspool") {
            $("#" + key).next().find(".active").removeClass("active");
            $("#" + key + " .active").removeClass("active");
        } else if (curPool == "crs") {
            $("#" + key).next().find(".active").removeClass("active");
        } else {
            $("#" + key + " .active").removeClass("active");
        }
        //sel面板中
        $(this).closest("ul").remove();
        selCount();
        fillOptionsPan();
        calculate();
    });
    //隐藏更多过关面板
    $(".hideMore").click(function() {
        $(this).closest(".cMore>p").hide();
    });
    //点击更多选项面板选项
    $("#optionMorePan").delegate("a", "click", function() {
        var indexAry = $(this).attr("num").split("_");
        var tmpStr = optionAry[indexAry[0]][indexAry[1]][1];
        $("#options>input").prop("checked", false);
        for (var i = 0; i < tmpStr.length; i++) {
            var num = Number(tmpStr.charAt(i)) - 2;
            $("#options>input").eq(Number(num)).prop("checked", true);
        }
        $("#user_select").val(optionAry[indexAry[0]][indexAry[1]][0]);
        calculate();
    });
    //点击过关选项
    $("#options").delegate("input", "click", function() {
        calculate();
    });
    //倍数-按钮
    $("#subBtn").click(function() {
        changeTimes(-1);
    });
    //倍数+按钮
    $("#addBtn").click(function() {
        changeTimes(1);
    });
    //输入倍数
    $("#Multiple").change(function() {
        var num = Number($("#Multiple").val());
        if (num < 1) num = 1;
        if (num > 100000) num = 100000;
        $("#Multiple").val(num);
        calculate();
    });
    //日期筛选checkbox
    $("#fDate").delegate("input:checkbox", "click", function() {
        $("#dataList a.foldBtn").eq($("#fDate input").index($(this))).click();
        c();
    });
    //让球筛选checkbox
    $("#fLetBall").delegate("input:checkbox", "click", function() {
        if ($(this).prop("checked")) {
            $("#dataList tr[l=" + $(this).attr("num") + "]").show();
        } else {
            $("#dataList tr[l=" + $(this).attr("num") + "]").hide();
        }
        updateHideNum();
        c();
    });
    //赛事筛选checkbox
    $("#fMatches").delegate("input:checkbox", "click", function() {
        var index = $("#fMatches input:checkbox").index($(this));
        if ($(this).prop("checked")) {
            $("#dataList tr[m=" + index + "]").show();
        } else {
            $("#dataList tr[m=" + index + "]").hide();
        }
        updateHideNum();
        c();
    });
    //全选 反选 全清
    $(".DangQian").delegate("a", "click", function() {
        var obj = $("#" + $(this).closest("i").attr("ctl"));
        switch ($(this).text()) {
            case "全选":
                obj.find("input").prop("checked", true);
                $("#dataList tr").show();
                $("#dataList .time").each(function() {
                    $(this).find(".foldBtn").text("隐藏");
                    $(this).find(".hideNum").text("0");
                });
                break;
            case "反选":
                $(this).closest("i").prev().find("input").click();
                break;
            case "全清":
                obj.find("input").prop("checked", false);
                $("#dataList table tr").hide();
                $("#dataList .time").each(function() {
                    $(this).find(".foldBtn").text("显示");
                    $(this).find(".hideNum").text($(this).next().find("tr").length);
                });
                break;
        }
        c();
    });
    //隐藏按钮
    $("#dataList").delegate("a.foldBtn", "click", function() {
        var index = $("#dataList a.foldBtn").index($(this));
        var obj = $(this).closest("tr");
        if ($(this).text() == "隐藏") {
            $(this).text("显示");
            obj.next().hide();
            var len = obj.next().find("tr").length;
            if (curPool == "crs" || curPool == 'crosspool') len = len / 2;
            obj.find(".hideNum").text(len);
            $("#fDate input").eq(index).removeAttr("checked");
        } else {
            $(this).text("隐藏");
            obj.next().show();
            obj.next().find("tr").show();
            var len = obj.next().find("tr[a!=1]:hidden").length;
            obj.find(".hideNum").text(len);
            $("#fDate input").eq(index).prop("checked", true);
        }
        c();
    });
    //隐藏一场
    $("#dataList").delegate(".hideMatch", "click", function() {
        $(this).closest("tr").hide();
        if (curPool == "crs" || curPool == "crosspool") $(this).closest("tr").next().hide();
        var obj = $(this).closest("table");
        var len = obj.find("tr[a!=1]:hidden").length;
        obj.closest("tr").prev().find(".hideNum").text(len);
        c();
    });
    //显示已隐藏的比赛
    $("#dataList").delegate(".showHide", "click", function() {
        var obj = $(this).closest("tr");
        obj.find("a.foldBtn").text("隐藏");
        obj.next().show();
        obj.next().find("tr[a!=1]:hidden").show();
        obj.find(".hideNum").text("0");
        c();
    });
    //点击奖金
    $("#dataList").delegate(".o", "click", function() {
        if ($(this).text() == "") return;
        if ($(this).hasClass("noBorder")) return;
        var obj = $(this).closest("tr");
        if (obj.attr("id") == undefined) {
            obj = obj.prev();
        }
        var key = obj.attr("id");
        var oIndex = $(this).closest("tr").find(".o").index($(this)) + poolOptionIndex[curPool];
        if (curPool == "crosspool" && $(this).closest("tr").attr("id") == undefined) {
            oIndex += $(this).closest("tr").prev().find(".o").length;
        }

        if ($(this).hasClass("active")) {
            //取消选择
            $(this).removeClass("active");
            //数组中
            selAry[key].odds[oIndex] = 1;
            //
            if (eval(selAry[key].odds.join("*")) == 1) {
                delete (selAry[key]);
            }
        } else {
            //选中
            $(this).addClass("active");
            if (selAry[key] == undefined) {
                selAry[key] = {};
                if (curPos.gameCode == "fb") {
                    selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                } else {
                    selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
                }

                selAry[key].num = obj.closest("table").closest("tr").prev().find(".DQtime").find("b").text().substr(0, 2) + obj.find(".hideMatch").text();
                selAry[key].hostTeam = obj.find("hn").text();
                selAry[key].guestTeam = obj.find("gn").text();
                selAry[key].goalLine = {};

                //判断场数
                if (!checkSelCount()) {
                    $(this).removeClass("active");
                    return;
                }

            }

            var lineObj = $(this).closest("td").find(".line");
            if (lineObj.length > 0) {
                selAry[key].goalLine[lineObj.attr("pool")] = lineObj.text();
            }

            var oddsStr = "";
            if (curPool == "crs") {
                oddsStr = $(this).contents().eq(2).text().replace(/ /g, "");
            } else {
                var oddsItem = $(this).find(".oddsItem");
                if (oddsItem.length == 0) {
                    oddsStr = $(this).text();
                } else {
                    oddsStr = oddsItem.text();
                }
            }
            selAry[key].odds[oIndex] = Number(oddsStr);
        }
        fillSelPan();
        fillOptionsPan();
        calculate();
    });
    //查看详细
    $("#betBonus").click(function() {
        var obj = $("#selDetailDiv");
        if (obj.css("display") == "none") {
            if (selCount() < 2) return;
            if ($("#betBonus").text() == "0") return;
            obj.html("&nbsp;&nbsp;计算中，请稍等...（如果浏览器长时间无反应，请刷新页面）");
            obj.show();
            calDetail();
        } else {
            obj.html("");
            obj.hide();
        }
    });

    //投注按钮
    $(".touzhuSub input").click(function() {
        if ($("#betMoney").text() == "0") return;
        var subObj = {};
        subObj.sport = curPos.gameCode;
        var optionStr = getCombinOptStr();
        var selectOption = "";
        for (var i = 0; i < optionStr.length; i++) {
            selectOption += optionStr.charAt(i) + "x1|";
        }
        subObj.select = selectOption.substr(0, selectOption.length - 1);
        subObj.multiple = Number($("#Multiple").val());
        subObj.money = $("#betMoney").text();
        subObj.combination = "";
        subObj.user_select = $("#user_select").val();
        var crossAry = { fb: { had: 0, hhad: 0, crs: 0, ttg: 0, hafu: 0 }, bk: { wnm: 0, mnl: 0, hilo: 0, had: 0} };
        for (var key in selAry) {
            for (var m = 0; m < poolIndex[curPos.gameCode].length; m++) {
                var poolStr = poolIndex[curPos.gameCode][m];
                var tmpStr = "";
                for (var j = poolOptionIndex[poolStr]; j < poolOptionCount[poolStr] + poolOptionIndex[poolStr]; j++) {
                    if (selAry[key].odds[j] != 1) {
                        tmpStr += oddsCode[poolStr][j - poolOptionIndex[poolStr]] + "#" + selAry[key].odds[j] + "&";
                    }
                }
                if (tmpStr != "") {
                    crossAry[subObj.sport][poolStr] = 1;
                    subObj.combination += poolStr + "|" + key + "|" + tmpStr.substr(0, tmpStr.length - 1) + ",";
                }
            }
        }
        //判断混串
        for (var key in crossAry[subObj.sport]) {
            if (crossAry[subObj.sport][key] == 1) {
                if (subObj.pool == undefined) {
                    subObj.pool = key;
                } else if (key != subObj.pool) {
                    subObj.pool = "crosspool";
                }
            }
        }
        if (subObj.combination != "") subObj.combination = subObj.combination.substr(0, subObj.combination.length - 1);
        $.post("Default.aspx", subObj, function(data, status) {
            console.info("Data: " + data + "\nStatus: " + status);
        });
        openBlank(host+"/www/football/confirm.php", subObj, 1);
        //openBlank("http://data.888win.cn/test/webtest/interface/confirm.php", subObj, 1);
    });

    fillSelPan();
    fillOptionsPan();
    calculate();

    //初始化日期选择
    var dateStr = "";
    var curDate = new Date();
    var preDate = curDate.getTime() - 24 * 60 * 60 * 1000;
    for (var i = 0; i < 7; i++) {
        var preDate = new Date(curDate.getTime() - 24 * 60 * 60 * 1000 * i);
        var monthStr = (preDate.getMonth() + 1) + "";
        if (monthStr.length == 1) monthStr = "0" + monthStr;
        var dayStr = preDate.getDate() + "";
        if (dayStr.length == 1) dayStr = "0" + dayStr;
        var str = preDate.getFullYear() + "-" + monthStr + "-" + dayStr;
        dateStr += "<option " + ((i == 0) ? " selected=\"selected\" " : "") + "value='" + str + "'>" + str + ((i == 0) ? "" : "") + "</option>";
    }
    $("#jsSelLotNum").html(dateStr);

    $("#jsSelLotNum").change(function() {
        clearSel();
        calculate();
        $.getScript(urlStr + "&d=" + $("#jsSelLotNum").val() + "&f=getDataBack", null);
        $("#tip").html("<font color='red'>数据加载中...</font>");
    });
});
function updateHideNum() {
    $("#dataList .time").each(function() {
        var len = $(this).next().find("tr[a!=1]:hidden").length;
        $(this).find(".hideNum").text(len);
    });
}
function fillSelPan() {
    var htmlStr = "";
    for (var key in selAry) {
        htmlStr += "<ul key='" + key + "'>" +
"                  <li>" + selAry[key].num + "</li>" +
"                  <li>" + selAry[key].hostTeam + "</li>" +
"                  <li>" + selAry[key].guestTeam + "</li>" +
"                  <li class=\"show\">";

        for (var i = 0; i < selAry[key].odds.length; i++) {
            if (selAry[key].odds[i] != 1) {
                for (var j = 0; j < poolIndex[curPos.gameCode].length; j++) {
                    var poolStr = poolIndex[curPos.gameCode][j];
                    var startNum = poolOptionIndex[poolStr];
                    var endNum = startNum + poolOptionCount[poolStr];
                    if (i >= startNum && i < endNum) {
                        var showStr = oddsTitle[poolStr][i - startNum];
                        if (poolStr == "hhad") {
                            showStr = "(" + selAry[key].goalLine.hhad + ")" + showStr;
                        }
                        htmlStr += "<b pool='" + poolStr + "' index='" + i + "'>" + showStr + "</b>";
                        break;
                    }
                }
            }
        }
        htmlStr +=
"                  </li>" +
"                  <li class=\'none\'>" +
"                    <input type=\"checkbox\""+ ((selAry[key].isDan)?" checked":"") +" />" +
"                  </li>" +
"                  <li class=\"Clear\"><a href=\"javascript:void(0);\">X</a></li>" +
"                </ul>";
    }
    $("#selPan div.FloatC").html(htmlStr);
    selCount();
}
//已选多少场
function selCount() {
    //已选多少场
    var len = $("#selPan .FloatC>ul").length;
    $("#selPanBtn>span").text(len);
    return len;
}
//删除全部已选择项
function clearSel() {
    selAry = {};
    fillSelPan();
    $("#dataList .active").removeClass("active");
}
function fillOptionsPan() {
    var existOptionAry = [];
    $("#options input").each(function() {
        if ($(this).prop("checked")) {
            existOptionAry.push($(this).attr("opt"));
        }
    });
    var count = selCount();
    var htmlStr = "";
    if (count < 2) htmlStr = "请选择两场及以上比赛";
    else {
//        if (count > 8) {
//        	count = 8;
//        } else 
        	if (count > selCountAry[curPool]) {
        	count = selCountAry[curPool];
        }
        for (var i = 2; i <= count; i++) {
        		htmlStr += "<input opt='"+i+"' type=\"checkbox\" /><span>" + i + "串1</span>";
        }
    }
    $("#options").html(htmlStr);

    //已选择项
    for (var i = 0; i < existOptionAry.length; i++) {
        $("#options input[opt='" + existOptionAry[i] + "']").prop("checked", true);
    }
    
    //更多面板
    htmlStr = "";
    if (count > 2) {
        for (var i = 3; i <= count; i++) {
        		for (var j = 1; j < optionAry[i].length; j++) {
                    htmlStr += "<a href=\"javascript:void(0);\" num='" + i + "_" + j + "'>" + optionAry[i][j][0] + "</a>";
               }
            htmlStr += "<br/>";
        }
    }
    $("#optionMorePan").html(htmlStr);
}
//改变倍数
function changeTimes(type) {
    var times = Number($("#Multiple").val());
    times += type;
    if (times < 1) times = 1;
    if (times > 100000) times = 100000;
    $("#Multiple").val(times);
    calculate();
}
//
function checkSelCount() {
    var count = selCount();
    if (count >= selCountAry[curPool]) {
//        alert("最多选择" + selCountAry[curPool] + "场赛事！");
//        return false;
    }
    return true;
}
//
function getCombinAryByNum(arr, num) {
    var r = [];
    (function f(t, a, n) {
        if (n == 0) return r.push(t);
        for (var i = 0, l = a.length; i <= l - n; i++) {
            f(t.concat(a[i]), a.slice(i + 1), n - 1);
        }
    })([], arr, num);
    return r;
}
//
/*四舍六入五成双*/
function rundFunc(data, m) {
    //if (data.toString().indexOf('万') > 0) return data; //如果数据中在万以上，不处理
    var dt = data.toFixed(8).toString();
    var pos = dt.indexOf('.') + 3;
    var key = parseInt(dt.charAt(pos));
    var vals = '';
    if (key < 5) {
        vals = dt.substr(0, pos);
    } else if (key > 5) {
        vals = (parseFloat(dt.substr(0, pos)) + 0.01).toString();
    } else {
        if (parseInt(dt.charAt(pos + 1)) > 0) {
            vals = (parseFloat(dt.substr(0, pos)) + 0.01).toString();
        } else if (parseInt(dt.charAt(pos - 1)) % 2) {
            vals = (parseFloat(dt.substr(0, pos)) + 0.01).toString();
        } else {
            vals = parseFloat(dt.substr(0, pos)).toString();
        }
    }
    return (Number(vals) * m).toFixed(2);
}
//
function oddsMNLimit(bonus, len) {
    bonus = rundFunc(bonus * 2, 1);
    //奖金限制
    switch (len) {
        case 2:
        case 3:
            if (bonus > 200000) bonus = 200000;
            break;
        case 4:
        case 5:
            if (bonus > 500000) bonus = 500000;
            break;
        case 6:
        case 7:
        case 8:
            if (bonus > 1000000) bonus = 1000000;
            break;
    }
    return Math.round((bonus * Number($("#Multiple").val())) * 100) / 100;
}
//
function getCombinByIndex(len, optionStr) {
    var parse2Num = Math.pow(2, len) - 1;
    var infoAry = [];
    var tmpAry = [];
    for (var m = 0; m < optionStr.length; m++) {
        for (var i = 1; i <= parse2Num; i++) {
            var radix2Str = i.toString(2);
            var addNum = 0;
            var tmpAry = [];
            for (var j = radix2Str.length - 1; j >= 0; j--) {
                var bitValue = Number(radix2Str.charAt(j));
                addNum += bitValue;
                if (bitValue > 0) {
                    var aryIndex = radix2Str.length - 1 - j;
                    tmpAry.push(aryIndex);
                }
            }
            if (addNum == Number(optionStr.charAt(m))) {
                infoAry.push(tmpAry);
            }
        }
    }
    return infoAry;
}
//
function getCombinOptStr() {
    var combinOptionStr = "";
    var optionSelObj = $("#options input:checked");
    for (var i = 0; i < optionSelObj.length; i++) {
        var optionStr = optionSelObj.eq(i).attr("opt");
        combinOptionStr += optionStr;
    }
    return combinOptionStr;
}
//
function checkDanCount(optStr, dLen) {
    for (var i = 0; i < optStr.length; i++) {
        var tmpStr = optStr.charAt(i);
        if (Number(tmpStr) < dLen) {
            alert("胆的数量多于当前过关选项中的串关方式");
            return false;
        }
    }
    return true;
}
//
function getOddsLen(ary) {
    var len = 0;
    for (var i = 0; i < ary.length; i++) {
        if (ary[i] > 1) {
            len++;
        }
    }
    return len;
}
//
function getBonus(optionsStr, oddMaxAry, oddDanAry, multiCountAry, dCountAry) {
    //var len = oddMaxAry.length;
    //oddMaxAry = oddMaxAry.slice(len - goalCount);
    //oddMinAry = oddMinAry.slice(0, goalCount);

    var maxBonus = 0;
    //var minBonus = 0;
    var mnCount = 0;
    var selAryLen = selCount();

    for (var i = 0; i < optionsStr.length; i++) {
        var len = Number(optionsStr.charAt(i)) - oddDanAry.length;
        if (len < 0) continue;
        var resultAry = getCombinAryByNum(oddMaxAry, len);
        if (multiCountAry != null) {
            var tmpAry = getCombinAryByNum(multiCountAry, len);
            for (var m = 0; m < tmpAry.length; m++) {
                tmpAry[m] = tmpAry[m].join("*");
                if (tmpAry[m] == "") tmpAry[m] = 1;
                if (dCountAry.length > 0) {
                    tmpAry[m] += "*" + dCountAry.join("*");
                }
            }
            mnCount += eval(tmpAry.join("+"));
        }
        for (var j = 0; j < resultAry.length; j++) {
            var mergeAry = resultAry[j].concat(oddDanAry);
            var tmpBonus = eval(mergeAry.join("*"));
            maxBonus += oddsMNLimit(tmpBonus, selAryLen);
        }
    }
    return { maxBonus: Math.round(maxBonus * 100) / 100, mnCount: mnCount };
}
//
function calculate() {
    $("#betMoney").text("0");
    $("#betBonus").text("0");
    //
    var selAryLen = selCount();
    var combinOptionStr = getCombinOptStr();
    if (combinOptionStr == "" && (selAryLen != 1 && curPool != "crs")) return;
    var times = Number($("#Multiple").val());

    if (selAryLen < 2) {
        //比分单场
        if (curPool == "crs" || curPool == "wnm") {
            var bonusValue = 0;
            var countValue = 0;
            for (var key in selAry) {
                var len = selAry[key].odds.length;
                for (var i = 0; i < len; i++) {
                    var curValue = selAry[key].odds[i];
                    if (curValue > 1 && bonusValue < curValue * 2 * times) {
                        bonusValue = curValue * 2 * times;
                    }
                    if (curValue > 1) countValue += 2;
                }
                $("#betMoney").text(countValue * times);
                $("#betBonus").text(bonusValue);
                $("#options").html("单关");
            }
        }
        return;
    }

    //
    dAry = [];
    tAry = [];
    for (var key in selAry) {
        if (selAry[key].isDan == undefined || !(selAry[key].isDan)) {
            tAry.push(selAry[key]);
        } else {
            dAry.push(selAry[key]);
        }
    }

    //判断胆个数
    if (!checkDanCount(combinOptionStr, dAry.length)) {
        return;
    }

    //胆中最大最小
    var dMaxAry = [];
    var dCountAry = [];
    var dMinAry = [];
    for (var i = 0; i < dAry.length; i++) {
        var minValue = 10000000;
        dCountAry.push(getOddsLen(dAry[i].odds));
        var maxValue = 1;
        for (var j = 0; j < dAry[i].odds.length; j++) {
            if (dAry[i].odds[j] == 1) {
                continue;
            }
            var oddsValue = Number(dAry[i].odds[j]);
            if (oddsValue > maxValue) {
                maxValue = oddsValue;
            }
            if (oddsValue < minValue) {
                minValue = oddsValue;
            }
        }
        dMinAry.push(minValue);
        dMaxAry.push(maxValue);
    }

    //查找拖最大值和最小值
    var calMaxAry = [];
    var calMinAry = [];
    var multiCountAry = [];
    for (var i = 0; i < tAry.length; i++) {
        multiCountAry.push(getOddsLen(tAry[i].odds));
        var minValue = 10000000;
        var maxValue = 1;
        for (var j = 0; j < tAry[i].odds.length; j++) {
            if (tAry[i].odds[j] == "") {
                continue;
            }
            var oddsValue = Number(tAry[i].odds[j]);
            if (oddsValue > maxValue) {
                maxValue = oddsValue;
            }
            if (oddsValue < minValue) {
                minValue = oddsValue;
            }
        }
        calMinAry.push(minValue);
        calMaxAry.push(maxValue);
    }

    var maxBonus = 0;
    var mnCount = 0;

    var obj = getBonus(combinOptionStr, calMaxAry, dMaxAry, multiCountAry, dCountAry);
    maxBonus = obj.maxBonus;
    minBonus = obj.minBonus;
    mnCount = obj.mnCount;
    $("#betMoney").text(mnCount * 2 * times);
    $("#betBonus").text(maxBonus);

    //
    min_maxAry = { "dMax": dMaxAry, "dMin": dMinAry, "tMax": calMaxAry.sort(), "tMin": calMinAry.sort() };
}
//
function getMMBonus(optionsStr, ary, goalCount) {

    var oddMaxAry = ary.tMax.slice(ary.tMax.length - goalCount + ary.dMax.length);
    var oddMinAry = ary.tMin.slice(0, goalCount - ary.dMax.length);

    var maxBonus = 0;
    var minBonus = 0;

    for (var i = 0; i < optionsStr.length; i++) {
        var optNum = Number(optionsStr.charAt(i));
        if (optNum > goalCount) continue;
        var len = optNum - ary.dMax.length;
        if (len < 0) continue;

        var resultAry = getCombinAryByNum(oddMaxAry, len);
        for (var j = 0; j < resultAry.length; j++) {
            var mergeAry = resultAry[j].concat(ary.dMax);
            var tmpBonus = eval(mergeAry.join("*"));
            maxBonus += oddsMNLimit(tmpBonus, optNum);
        }

        resultAry = getCombinAryByNum(oddMinAry, len);
        for (var j = 0; j < resultAry.length; j++) {
            var mergeAry = resultAry[j].concat(ary.dMin);
            var tmpBonus = eval(mergeAry.join("*"));
            minBonus += oddsMNLimit(tmpBonus, optNum);
        }
    }
    return { maxBonus: Math.round(maxBonus * 100) / 100, minBonus: Math.round(minBonus * 100) / 100, goalCount: goalCount };
}
//
function getMNDetail(ary, optionStr) {
    var infoAry = getCombinByIndex(ary.length, optionStr);
    var returnAry = [];
    var radix = 32;
    for (var i = 0; i < infoAry.length; i++) {
        var tmpAry = infoAry[i];
        var oddsLenAry = [];
        for (var j = 0; j < tmpAry.length; j++) {
            var len = getOddsLen(ary[tmpAry[j]].odds);
            oddsLenAry.push(len.toString(radix));
        }
        var lenStr = oddsLenAry.join("");
        var startNum = parseInt((Math.pow(2, tmpAry.length) - 1).toString(2), radix);
        var endNum = parseInt(lenStr, radix);
        for (var j = startNum; j <= endNum; j++) {
            var tmpStr = j.toString(radix);
            var isContinue = false;
            for (var m = 0; m < tmpStr.length; m++) {
                if (tmpStr.charAt(m) > lenStr.charAt(m)) {
                    isContinue = true;
                    var str = tmpStr.substr(0, m);
                    for (var n = m; n < tmpStr.length; n++) {
                        str += "1";
                    }
                    num = parseInt(str, radix);
                    num += Math.pow(radix, tmpStr.length - m) - 1;
                    j = num;
                    break;
                }
            }
            if (isContinue) continue;
            returnAry.push([tmpStr, i]);
        }
    }
    return { combinAry: infoAry, indexAry: returnAry };
}
//
function calDetail() {
    var optionStr = getCombinOptStr();
    
    if (!checkDanCount(optionStr, dAry.length)) {
        return;
    }
    var htmlStr = "";
    var selAryLen = selCount();
    var times = Number($("#Multiple").val());
    
    //计算中n场最大最小
    var mmStr = "";
    for (var i = 2; i <= selAryLen; i++) {
        if (i < Number(optionStr.charAt(0))) continue;
        var mmObj = getMMBonus(optionStr, min_maxAry, i);
        mmStr += "中" + mmObj.goalCount + "场(" + mmObj.minBonus + "～" + mmObj.maxBonus + ") ";
    }
    htmlStr = mmStr+"<br>";
    $("#selDetailDiv").html(htmlStr);

    //计算胆中
    var ary = getMNDetail(dAry, dAry.length + "");
    var combinDAry = ary.combinAry;
    var indexDAry = ary.indexAry;
    var dResultAry = [];
    for (var i = 0; i < indexDAry.length; i++) {
        var oddsIndexStr = indexDAry[i][0] + "";
        var aryIndex = indexDAry[i][1];
        var fOdds = 1;
        var matchIndexStr = "";
        var tmpStr = "";
        for (var j = 0; j < oddsIndexStr.length; j++) {
            matchIndexStr += combinDAry[aryIndex][j];
            var tmpObj = dAry[combinDAry[aryIndex][j]];
            var oIndex = Number(oddsIndexStr.charAt(j)) - 1;
            var tmpOddsAry = [];
            for (var m = 0; m < tmpObj.odds.length; m++) {
                if (tmpObj.odds[m] != 1) {
                    tmpOddsAry.push({ "value": tmpObj.odds[m], "cn": oddsIndex[m],"num":tmpObj.num });
                }
            }

            fOdds *= Number(tmpOddsAry[oIndex].value);
            tmpStr += tmpOddsAry[oIndex].num + "(" + tmpOddsAry[oIndex].cn + "@" + tmpOddsAry[oIndex].value + ")x";
        }
        dResultAry.push({ "str": tmpStr, "bonus": fOdds });
    }

    //计算拖中
    var combinOpt = "";
    for (var i = 0; i < optionStr.length; i++) {
        var tmpOpt = Number(optionStr.charAt(i)) - dAry.length;
        if (tmpOpt > 0) {
            combinOpt += tmpOpt;
        }
    }
    ary = getMNDetail(tAry, combinOpt);
    var combinAry = ary.combinAry;
    var indexAry = ary.indexAry;
    var resultStr = "";
    if (indexAry.length > 0) {
        for (var i = 0; i < indexAry.length; i++) {
            var oddsIndexStr = indexAry[i][0] + "";
            var aryIndex = indexAry[i][1];
            var fOdds = 1;
            var tmpStr = "";
            var matchIndexStr = "";
            for (var j = 0; j < oddsIndexStr.length; j++) {
                matchIndexStr += combinAry[aryIndex][j];
                var tmpObj = tAry[combinAry[aryIndex][j]];
                var oIndex = Number(oddsIndexStr.charAt(j)) - 1;

                var tmpOddsAry = [];
                for (var m = 0; m < tmpObj.odds.length; m++) {
                    if (tmpObj.odds[m] != 1) {
                        tmpOddsAry.push({ "value": tmpObj.odds[m], "cn": oddsIndex[m],"num":tmpObj.num });
                    }
                }

                fOdds *= Number(tmpOddsAry[oIndex].value);
                tmpStr += tmpOddsAry[oIndex].num + "(" + tmpOddsAry[oIndex].cn + "@" + tmpOddsAry[oIndex].value + ")x";
            }
            if (dResultAry.length > 0) {
                //添加胆中条目
                for (var n = 0; n < dResultAry.length; n++) {
                    resultStr += "<span>" + (oddsIndexStr.length + dAry.length) + "串1 " + (tmpStr + dResultAry[n].str + times + "倍") + " " + oddsMNLimit(fOdds * dResultAry[n].bonus, oddsIndexStr.length + dAry.length) + "</span><br/>";
                }
            } else {
                resultStr += "<span>" + (oddsIndexStr.length + dAry.length) + "串1 " + tmpStr + times + "倍" + " " + oddsMNLimit(fOdds, oddsIndexStr.length) + "</span><br/>";
            }
        }

        //
        if (optionStr.indexOf("" + dAry.length) != -1) {
            for (var n = 0; n < dResultAry.length; n++) {
                resultStr += "<span>" + dAry.length + "串1 " + (dResultAry[n].str + times + "倍") + " " + oddsMNLimit(dResultAry[n].bonus, dAry.length) + "</span><br/>";
            }
        }

    } else { //拖为0
        for (var n = 0; n < dResultAry.length; n++) {
            var tmpStr = "<span>" + dAry.length + "串1 ";
            resultStr += (tmpStr + dResultAry[n].str + times + "倍") + " " + oddsMNLimit(dResultAry[n].bonus, dAry.length) + "</span><br/>";
        }
    }
    $("#selDetailDiv").html(htmlStr + resultStr);
}


function openBlank(action, data, n) {
    var form = $("<form/>").attr('action', action).attr('method', 'post');
    if (n)
        form.attr('target', '_blank');
    var input = '';
    $.each(data, function(i, n) {
        input += '<input type="hidden" name="' + i + '" value="' + n + '" />';
    });
    form.append(input).appendTo("body").css('display', 'none').submit();
}