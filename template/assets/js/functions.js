const numberWithCommas = (x) => {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
};


const display_notifications = (messages, type, selector) => {

    let html = '';
    type = type == 'error' ? 'danger' : type;

    for(let message of messages) {

        html += `
            <div class="alert alert-${type} animated fadeInDown">
                <button type="button" class="close" data-dismiss="alert">×</button>
                ${message}
            </div>`;

    }

    $(selector).html(html);

};


const fade_out_redirect = ({ url, selector = 'body', wait_time = 70 }) => {

    setTimeout(() => {
        $(selector).fadeOut(() => {
            $(selector).html('<div class="vw-100 vh-100 d-flex align-items-center"><div class="col-2 text-center mx-auto" style="width: 3rem; height: 3rem;"><div class="spinner-grow"><span class="sr-only">Loading...</span></div></div></div>').show();
        });

        setTimeout(() => window.location.href = url, 100)
    }, wait_time)

};


const save_report = (event, success_callback) => {
	let $event = $(event.currentTarget);
    let instagram_user_id = $event.data('id');
    let form_token = $('input[name="form_token"]').val();

    $.ajax({
        type: 'POST',
        url: 'save_report_ajax',
        data: {
            instagram_user_id,
            form_token
        },
        success: (data) => {
            if (data.status == 'error') {
                alert('Please try again later, something is not working properly.');
            }

            else if(data.status == 'success') {
                $event.fadeIn().html(data.details.html);

                success_callback();
            }
        },
        dataType: 'json'
    });

    event.preventDefault();
};

const email_report_toggle = event => {
    let $event = $(event.currentTarget);
    let instagram_user_id = $event.data('id');
    let form_token = $('input[name="form_token"]').val();

    $.ajax({
        type: 'POST',
        url: 'email_report_toggle_ajax',
        data: {
            instagram_user_id,
            form_token
        },
        success: (data) => {
            if (data.status == 'error') {
                alert('Please try again later, something is not working properly.');
            }

            else if(data.status == 'success') {

            }
        },
        dataType: 'json'
    });

    event.preventDefault();
};

const set_cookie = (name, value, minutes) => {
    let exdate = new Date();
    exdate.setMinutes(exdate.getMinutes() + minutes);
    let c_value = escape(value) + ((minutes == null) ? '' : '; expires=' + exdate.toUTCString());
    document.cookie = name + "=" + c_value;
};

const get_cookie = cookie_name => {
    let cookies = document.cookie.split(';');

    let [ found_cookie ] = cookies.filter(cookie_string => {
        let [name, value] = cookie_string.trim().split('=');

        return name == cookie_name;
    });

    if(!found_cookie) return false;

    let [name, value] = found_cookie.trim().split('=');

    return value;
};

const is_url = (str) => (str.includes('http://') || str.includes('https://'));
