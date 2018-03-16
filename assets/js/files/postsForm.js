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