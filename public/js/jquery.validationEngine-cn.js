
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
					"regex":"none",
					"alertText":"· 此栏为必填项",
					"alertTextCheckboxMultiple":"· 请选择一个选项",
					"alertTextCheckboxe":"· 此选择框为必选"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "· 输入不可少于 ",
                    "alertText2": " 个字符"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "· 输入不可超过 ",
                    "alertText2": " 个字符"
                },
                "min": {
                    "regex": "none",
                    "alertText": "· 最小值为 "
                },
                "max": {
                    "regex": "none",
                    "alertText": "· 最大值为 "
                },
                "past": {
                    "regex": "none",
                    "alertText": "· 日期不可后于 "
                },
                "future": {
                    "regex": "none",
                    "alertText": "· 日期不可早于 "
                },	
                "maxCheckbox": {
						"regex":"none",
						"alertText":"· 复选框超过最大可选数"
                },
                "minCheckbox": {
						"regex":"none",
						"alertText":"· 请至少选择 ",
						"alertText2":" 项"
				},
                "equals": {
                    "regex": "none",
                    "alertText": "· 两次输入的密码不同"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
					"alertText":"· 电话号码格式有误"
                },
				"mobilenumber":{
					"regex":/^1[358]\d{9}$|^1060[1-9]\d{1,2}\d{7,8}$/,
//					"regex":/^\d{11}$/,
					"alertText":"· 手机号码格式有误"
				},
                "email": {
                    // Simplified, was not working in the Iphone browser
                    "regex": /^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/,
					"alertText":"· 电子邮件地址格式有误"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "· 数字格式有误"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "· 数字格式有误"
                },
                "date": {
                    // Date in ISO format. Credit: bassistance
                    "regex": /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/,
                         "alertText":"· 日期格式有误，日期格式为：YYYY-MM-DD"
                },
                "ipv4": {
                    "regex": /^([1-9][0-9]{0,2})+\.([1-9][0-9]{0,2})+\.([1-9][0-9]{0,2})+\.([1-9][0-9]{0,2})+$/,
                    "alertText": "· IP地址格式有误"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\·\+,;=]|:)·@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])·([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])·([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d·)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\·\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\·\+,;=]|:|@)·)·)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\·\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)·)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\·\+,;=]|:|@)|\/|\?)·)?$/,
                    "alertText": "· URL格式有误"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
					"alertText":"· 请输入数字"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
					"alertText":"· 请输入英文字符"
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "· 请输入数字或字母"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "· This user is already taken",
                    "alertTextLoad": "· Validating, please wait"
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "· This name is already taken",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "· This name is available",
                    // speaks by itself
                    "alertTextLoad": "· Validating, please wait"
                },
                "validate2fields": {
                    "alertText": "· Please input HELLO"
                }
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);


    
