/**
 * THIS is a copy/paste of the "contact_me.js" file,
 * from the "startbootstrap-freelancer" module.
 * It has been altered for this site.
 */

$(function() {
    if (!window.CONTACT_FORM_ID) {
        return;
    }
    $("#"+window.CONTACT_FORM_ID+" input,#"+window.CONTACT_FORM_ID+" textarea").jqBootstrapValidation({
        filter: function() {
            return $(this).is(":visible");
        },
    });
});
