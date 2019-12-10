jQuery(document).ready(function () {
  jQuery('body').on('click','.lgs-copy',function () {
    var current = jQuery(this),
      old_text = current.text(),
      id = current.parent().find('.lgs-target').attr('id');
    console.log(id);
    copyToClipboard(document.getElementById(id));
    current.fadeIn(500,function(){
      current.html('Copied!');
    }).delay(1000).fadeIn(500, function(){
      current.html(old_text);
    });
    return false;
  });

    jQuery('body').on('click','#copyButton',function () {
      var old_text = jQuery(this).text();
      copyToClipboard(document.getElementById("copyTarget"));
      nextMsg('#copyButton','Copied!', old_text);
      return false;
    });

    jQuery('body').on('click','#copyButton-desktop',function () {
      var old_text = jQuery(this).text();
      copyToClipboard(document.getElementById("copyTarget-desktop"));
      nextMsg('#copyButton-desktop','Copied!', old_text);
      return false;
    });

    function nextMsg(btn,text1,text2) {
        jQuery(btn).fadeIn(500,function(){jQuery(btn).html(text1);}).delay(1000).fadeIn(500, function(){jQuery(btn).html(text2);});
    }

    jQuery('body').on('click','.copyButton-caption',function(){
        copyToClipboard(document.getElementById("copyTarget-caption"));
        nextMsg('.copyButton-caption','Copied!',jQuery(this).text());
        return false;
    });

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);

        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            //currentFocus.focus();
        }

        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        target.blur();
        return succeed;
    }
});