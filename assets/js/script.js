function bootstrapAlert(text) {
    'use strict';

    return '<div class="alert alert-' + text.class + ' alert-dismissible" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
        '<strong>' + text.title + '</strong>: ' + text.body + '</div>';
}

function select2Start($ELEMENT) {
    $($ELEMENT).select2({
        language:'pt-br'
    });
}

function select2Destroy($ELEMENT) {
    if($($ELEMENT).data('select2')){
        $($ELEMENT).select2('destroy')
    }
}

function spinnerStart($ELEMENT) {
    'use strict';

    $($ELEMENT)
        .addClass('sobreposicao')
        .html(
            '<div class="spinner2"></div>' +
            '<p class="spinnerText"">Aguardando Resposta</p>'+
            '<div class="clearfix"></div>'
        ).fadeIn();
}

function spinnerDestroy($ELEMENT) {
    'use strict';
    $($ELEMENT).removeClass('sobreposicao').html('').fadeOut();
}

function pnotify($type,$text) {
    new PNotify({
        title:$text.title,
        text:$text.text,
        type:$type,
        styling: 'fontawesome',
        buttons:{
            labels: {close: "Fechar", stick: "Fixar",unstick:"Desfixar"}
        }
    });
}

function pnotifyConfirm($text) {
    (new PNotify({
        title: $text.title,
        text: $text.text,
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {
            'dir1': 'down',
            'dir2': 'right',
            'modal': true
        }
    })).get().on('pnotify.confirm', function() {
        return true;
    }).on('pnotify.cancel', function() {
        return false;
    });
}

function notifyLoad($id,$limit) {
    'use strict';

    var $notifyLimit;

    $.ajax({
        type:'get',
        url:baseAPI + 'notify/'+$id+'?limit=0,'+$limit,
        dataType:'json',
        success:function (e) {
            var notify = $('#notifyList');

            for(var i = 0; i < e.notify.length; i++){
                if(e.notify[i].read === 1 ){
                    notify.append('' +
                        '<li id="notify-'+ e.notify[i].id +'" class="notifyRead" onclick="viewNofify('+ e.notify[i].id +')">' +
                        '<a>' +
                        '<span class="image">'+
                        '<img src="https://scontent.fcwb2-1.fna.fbcdn.net/v/t1.0-9/1928756_1173674272660022_9137393039815591469_n.jpg?oh=63e13628c65bc8077260b2964a5f2556&oe=58BCD81F" alt="Profile Image"/>' +
                        '</span>' +
                        '<span>' +
                        '<span>'+ e.notify[i].name +'</span>' +
                        '<span class="time">'+ e.notify[i].data +'</span></span>' +
                        '<span class="message">\n'+ e.notify[i].body +'\n        </span>\n    </a>\n</li>')
                } else {
                    notify.append('' +
                        '<li id="notify-'+ e.notify[i].id +'" onclick="viewNofify('+ e.notify[i].id +')">' +
                        '<a>' +
                        '<span class="image">'+
                        '<img src="https://scontent.fcwb2-1.fna.fbcdn.net/v/t1.0-9/1928756_1173674272660022_9137393039815591469_n.jpg?oh=63e13628c65bc8077260b2964a5f2556&oe=58BCD81F" alt="Profile Image"/>' +
                        '</span>' +
                        '<span>' +
                        '<span>'+ e.notify[i].name +'</span>' +
                        '<span class="time">'+ e.notify[i].data +'</span></span>' +
                        '<span class="message">\n'+ e.notify[i].body +'\n        </span>\n    </a>\n</li>')
                }
            }

            $('#notifyBadge').html(e.total);

            $notifyLimit = $notifyLimit + $notifyLimitB;
        }
    });
}

function notifyRealTime($id,$limit) {
    $.ajax({
        type:'get',
        url:baseAPI + 'notify/new/'+$id+'?timestamp='+$limit,
        dataType:'json',
        success:function (e) {
            var notify = e.notify;

            for(var i in notify){
                if(notify[i].type == '2' || notify[i].type == '4' || notify[i].type == '5'){
                    new PNotify({
                        title:notify[i].name,
                        text:notify[i].body,
                        type:'info',
                        styling: 'fontawesome',
                        hide: false,
                        buttons:{
                            labels: {close: "Fechar", stick: "Fixar",unstick:"Desfixar"}
                        }
                    });
                } else {
                    configNotify('info',{title:notify[i].name,text:notify[i].body});
                }
            }

            $('#notifyBadge').html(e.total);

            notifyRealTime($id,e.timestamp);
        }
    });
}

function validarCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

}

function validarCPF(cpf) {
    'use strict';

    cpf = cpf.replace(/[^\d]+/g,'');
    if(cpf === ''){
        return false;
    }

    // Elimina CPFs invalidos conhecidos
    if (cpf.length !== 11 ||
        cpf === "00000000000" ||
        cpf === "11111111111" ||
        cpf === "22222222222" ||
        cpf === "33333333333" ||
        cpf === "44444444444" ||
        cpf === "55555555555" ||
        cpf === "66666666666" ||
        cpf === "77777777777" ||
        cpf === "88888888888" ||
        cpf === "99999999999")
    {
        return false;
    }
    // Valida 1o digito
    var add = 0;
    for (var i=0; i < 9; i ++){
        add += parseInt(cpf.charAt(i)) * (10 - i);
    }
    var rev = 11 - (add % 11);
    if (rev === 10 || rev === 11){
        rev = 0;
    }

    if (rev !== parseInt(cpf.charAt(9))){
        return false;
    }

    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i ++){
        add += parseInt(cpf.charAt(i)) * (11 - i);
    }
    rev = 11 - (add % 11);
    if (rev === 10 || rev === 11){
        rev = 0;
    }

    if(rev !== parseInt(cpf.charAt(10))){
        return false;
    }

    return true;
}

function numberParaReal(numero) {
    'use strict';

    var numero = numero.toFixed(2).split('.');
    numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}
$('input').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
});
var postsForm = {

    title: null,
    textarea:  null,
    author: null,
    date: null,
    status: null,
    categorie: null,
    tags: null,
    type: null,

    loadPostFormData: function () {
        this.title = $('#post_title');
        this.textarea = $('#post_content');
        this.author = $('#post_author');
        this.date = $('#post_date');
        this.status = $('#post_status');
        this.category = $('#post_categorie');
        this.tags = $('#post_tags');
        this.type = $('#post_type');
    },

    novopost: function () {
        
        var $formData = {
            title: this.title.val(),
            content: tinyMCE.get('post_content').getContent(),
            author: this.author.val(),
            date: this.date.val(),
            status: this.status.val(),
            category: this.category.val(),
            tags: this.tags.val(),
            type: this.type.val()
        };

        $.ajax({
            type: 'post',
            url: baseAPI + 'post/novo',
            data: $formData,
            dataType: 'json',
            sucess: function () {

            }
        })
    }
};