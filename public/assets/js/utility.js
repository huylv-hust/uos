var utility = {
    zen2han : function(e){
        var str = e.value;
        str = str.replace(/[Ａ-Ｚａ-ｚ０-９－！”＃＄％＆’（）＝＜＞，．？＿［］｛｝＠＾～￥]/g, function (s) {
            return String.fromCharCode(s.charCodeAt(0) - 65248);
        });
        e.value = str;
    },
    date_format: function(value)
    {
        var list_month_30 = [4,6,9,11],
            list_month_31 = [1,3,5,7,8,10,12],
            leap_year = false;
        if(value == '') return true;
        if(value.match(/^\d{4}-\d{2}-\d{2}$/))
        {
            var arr = value.split('-'),
                year = parseInt(arr[0]),
                month = parseInt(arr[1]),
                day = parseInt(arr[2]);
            if((year % 100 != 0 && year % 4 == 0) || year % 400 == 0) leap_year = true;
            if(((month < 1 || month > 12) || day < 1 || year < 1)
                || (leap_year == true && month == 2 && day > 29)
                || (leap_year == false && month == 2 && day > 28)
                || ($.inArray(month,list_month_30) >=0 && day > 30)
                || ($.inArray(month,list_month_31) >=0 && day > 31))
                return false;

            return true;
        }
        return false;
    },
    html_encode: function(item)
    {
        return item.replace(/[\x26\x0A\<>'"]/g,function(r){return"&#"+r.charCodeAt(0)+";"})
    },
    lpad: function(str, char, len) {
        str = str.toString();
        while (str.length < len) {
            str = char + str;
        }
        return str;
    },
    get6monthAfter: function(start) {
        var arr = start.split('-');

        var year = parseInt(arr[0]);

        var month = parseInt(arr[1]) + 6;
        if (month > 12) {
            month -= 12;
            year++;
        }

        var day = parseInt(arr[2]);
        if (
            month == 4 ||
            month == 6 ||
            month == 9 ||
            month == 11
        ) {
            if (day > 30) { day = 30; }
        }

        if (month == 2) {
            if ((year % 100 != 0 && year % 4 == 0) || year % 400 == 0) {
                if (day > 29) { day = 29; }
            } else {
                if (day > 28) { day = 28; }
            }
        }

        return year + '-' + utility.lpad(month, '0', 2) + '-' + utility.lpad(day, '0', 2);
    }
};
