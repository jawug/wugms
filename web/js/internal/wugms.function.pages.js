$(document).ready(function() {
    var id = $('.pagetitle').attr('id');
    //console.log(id);
    /* Set the active class */
    switch (id) {
        /* Public pages */
        case 'page_cnd':
            $('#cnd').addClass('active');
            $('#public').addClass('active');
            break;
        case 'page_wifi':
            $('#wifi').addClass('active');
            $('#public').addClass('active');
            break;
        case 'page_us':
            $('#us').addClass('active');
            $('#public').addClass('active');
            break;
        case 'page_qos':
            $('#qos').addClass('active');
            $('#public').addClass('active');
            break;

            /* MS pages - */
        case 'page_ms':
            $('#ms').addClass('active');
            break;

            /* MS pages - User */
        case 'page_usr_dash':
            $('#usr_dash').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_usr_rb_man':
            $('#usr_rb_man').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_usr_scr_man':
            $('#usr_scr_man').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_usr_sites':
            $('#usr_sites').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_usr_ssids':
            $('#gen_ssid').addClass('active');
            $('#ms').addClass('active');
            break;
			
            /* MS pages - Admin */
        case 'page_adm_dash':
            $('#adm_dash').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_adm_rb_man':
            $('#adm_rb_man').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_adm_scr_man':
            $('#adm_scr_man').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_adm_sites':
            $('#adm_sites').addClass('active');
            $('#ms').addClass('active');
            break;
        case 'page_adm_users':
            $('#adm_users').addClass('active');
            $('#ms').addClass('active');
            break;

            /* MS pages - Beta */
        case 'page_beta_dash':
            $('#beta_dash').addClass('active');
            $('#ms').addClass('active');
            break;

            /* MS pages - Mancom */
        case 'page_mancom':
            $('#mancom').addClass('active');
            $('#ms').addClass('active');
            break;


    }
});