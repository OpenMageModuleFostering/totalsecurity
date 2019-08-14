
$j(function(){
    $j('body').on('click', '.totalsecurity-option', function(e){
        e.preventDefault();
        var method = $j(this).data('method');
        var mobileNumber = $j("#totalsecurityMobile")[0];
        var landlineNumber = $j("#totalsecurityLandline")[0];
        $j('.totalsecurity-response').hide();
        switch(method){
            case 'app':
                if($j("#totalsecurityMobile").length){
                    checkNumber(mobileNumber);
                }
                $j('.totalsecurity-form li.totalsecurity-mobile').slideDown('fast');
                $j('.totalsecurity-form li.totalsecurity-landline, .totalsecurity-form li.totalsecurity-email, .change-mobile, .change-landline').slideUp('fast');
                break;
            case 'voice':
                if($j("#totalsecurityLandline").length){
                    checkNumber(landlineNumber);
                }
                $j('.totalsecurity-form li.totalsecurity-landline').slideDown('fast');
                $j('.totalsecurity-form li.totalsecurity-mobile, .totalsecurity-form li.totalsecurity-email, .change-mobile, .change-landline').slideUp('fast');
                break;
            case 'email':
                $j('.totalsecurity-form li.totalsecurity-email').slideDown('fast');
                $j('.totalsecurity-form li.totalsecurity-mobile, .totalsecurity-form li.totalsecurity-landline, .change-mobile, .change-landline').slideUp('fast');
                break;
        }
    });
    $j('.totalsecurity-option.mobile').trigger('click');
});

function isUkMobile(s)
{
    // 74xx, 75xx, 7624, 77xx, 78xx, and 79xx
    // WiFi numbers on 79112 and 79118. Personal numbering on 70. Pagers on 76xx.  
    var localPart = s.substring(getLocalNumberPosition(s));
    if (localPart.length == 10)
    {
        if (localPart.match(/^74/) || localPart.match(/^75/) || localPart.match(/^77/) || localPart.match(/^78/) || localPart.match(/^7624/)
            || (localPart.match(/^79/) && !(localPart.match(/^79112/) || localPart.match(/^79118/))))
        {
            return true;
        }
    }
    return false;
}

function isUkLandline(s)
{
    // 1 or 2
    var localPart = s.substring(getLocalNumberPosition(s));
    if (localPart.length >= 9 && localPart.length <= 10)
    {
        if (localPart.match(/^1/) || localPart.match(/^2/))
        {
            return true;
        }
    }
    return false;
}

function isNonGeopraphic(s)
{
    // 3
    var localPart = s.substring(getLocalNumberPosition(s));
    if (localPart.length == 10)
    {
        if (localPart.match(/^3/))
        {
            return true;
        }
    }
    return false;
}

function getLocalNumberPosition(s)
{
    if (s.match(/^0044/))
    {
        return 4;
    }
    else
    {
        if (s.match(/^\+44/))
        {
            return 3;
        }
        else
        {
            if (s.match(/^44/))
            {
                return 2;
            }
            else
            {
                if (s.match(/^0/))
                {
                    return 1;
                }
            }
        }
    }

    return 0;
}

/*
 Will clean a string corresponding to a number, will remove all non digits,
 restrict length and permit + is prefix is set

 */
function cleanNumber(number, length, allowInternationalPrefix)
{
    var digit = /\d/;
    var firstDigit = /\+|\d/;
    // E164 max length is 16 including + or 17 with outbound dialing code (2 digit)
    if (length == null) length = 17;
    if (allowInternationalPrefix == null) allowInternationalPrefix = true;

    if (number.length == 0) return s;

    var chars = number.trim().split('');
    var arrayLength = (chars.length > length ? length - 1 : chars.length - 1)

    for (var i = (chars.length - 1) ; i > arrayLength; i--)
    {
        chars[i] = '';
    }

    for (var i = arrayLength; i > (allowInternationalPrefix ? 1 : 0) ; i--)
    {
        if (!chars[i].match(digit))
        {
            chars[i] = '';
        }
    }

    if (allowInternationalPrefix && !chars[0].match(firstDigit))
    {
        chars[0] = '';
    }

    return chars.join('');
}
function checkNumber(e)
{
    if (e.value != '' && e.value != e.getAttribute("placeholder"))
    {
        e.value = cleanNumber(e.value,15); //0044 XXXXX XXXXXX

        if (isUkMobile(e.value))
        {
            // Mobile
            enableButton($j('.totalsecurity-submit.sms'));
            enableButton($j('.totalsecurity-submit.voice'));
            return;
        }
        if (isUkLandline(e.value))
        {
            // Landline
            enableButton($j('.totalsecurity-submit.voice'));
            disableButton($j('.totalsecurity-submit.sms'));
            return;
        }
    }
    // Not a number
    disableButton($j('.totalsecurity-submit.voice'));
    disableButton($j('.totalsecurity-submit.sms'));
}
// Used for the Magento customer Registration process to ensure customer supplies a valid Mobile number
function checkMobile(e)
{
    if (e.value != '' && e.value != e.getAttribute("placeholder"))
    {
        e.value = cleanNumber(e.value,15); //0044 XXXXX XXXXXX

        if (isUkMobile(e.value))
        {
            // Mobile
            enableButton($j('button.button'));
            return;
        }
    }
    // Not a number
    disableButton($j('.button.button'));
}
function disableButton(e)
{
    $j(e).addClass('disabled').attr('disabled', 'disabled');
}

function enableButton(e)
{
    $j(e).removeClass('disabled').removeAttr('disabled');
}
