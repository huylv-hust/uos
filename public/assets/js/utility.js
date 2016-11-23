var utility = {
    zen2han : function(e){
        var str = e.value;
        str = str.replace(/[Ａ-Ｚａ-ｚ０-９－！”＃＄％＆’（）＝＜＞，．？＿［］｛｝＠＾～￥]/g, function (s) {
            return String.fromCharCode(s.charCodeAt(0) - 65248);
        });
        e.value = str;
    }
};