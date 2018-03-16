var login = {
    login_form: null,
    recovery_form: null,
    new_user: null,
    div_alert: null,

    setLoginVariables: function () {
        this.login_form = $('#login_form');
        this.div_alert = $('#alert');
    },

    login: function () {
        var $this = this,
            $formData = this.login_form.serializeArray();

        var $email = this.login_form.find('[name="email"]'),
            $password = this.login_form.find('[name="password"]');
        
        $.ajax({
            type:'post',
            url: baseAPI + 'login/login',
            data: $formData,
            headers: {
                'X-APP-Auth':'jhasdjkjkasdlcasdasda57d768asd89as7d9a8d'
            },
            dataType: 'json',
            success: function (e) {
                $this.div_alert.html('');
                if(e.status === '1'){
                    e.message.forEach(function (a) {
                        $this.div_alert.html(bootstrapAlert({
                            type:'success',
                            title:'',
                            body: a
                        }));
                    });

                    if(is_redirect){
                        window.location.replace(baseURL + redirect_url);
                    } else {
                        window.location.reload();
                    }
                } else if(e.status === '0'){
                    console.log(e);
                    e.message.forEach(function (a) {
                        $this.div_alert.html(bootstrapAlert({
                            type:'warning',
                            title:'',
                            body: a
                        }));
                    });
                }
            }
        });
    }
};