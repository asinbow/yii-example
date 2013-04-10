(function () {

    var apiPrefix = 'dynamic.php/api';

    var User = Backbone.Model.extend({
    });

    var Users = Backbone.Collection.extend({
        model: User,
        url: apiPrefix + '/user/'
    });

    var UserRow = Backbone.View.extend({
        tagName: 'li',
        template: '<%= name %> / <%= email %> / <%= roll_id %> / <%= valid %>',
        events: {
            'click .check': 'check',
        },
        initialize: function () {
            _.bindAll(this, 'render', 'check', 'remove');
            this.model.bind('change', this.render);
            this.model.bind('destroy', this.remove);
            this.render();
        },
        render: function () {
            var text = _.template(this.template, this.model.attributes);
            var el = $(this.el).text(text);
            return this;
        },
        check: function () {
        }
    });

    var UserView = Backbone.View.extend({
        template: '<input id="new-user" type="button" value="Create user" /><input id="submit" type="button" value="Submit" /><ul></ul>',
        events: {
            'click #submit': 'doSubmit',
            'keydown #new-user': 'testReturn'
        },
        initialize: function () {
            $(document.body).append(this.el);
            $(this.el).html(this.template);
            _.bindAll(this, 'addUser', 'render');
            this.users = new Users;
            this.users.bind('add', this.addUser);
            this.users.bind('reset', this.render);
            this.users.fetch();
        },
        testReturn: function (e) {
            (e.keyCode==13) && this.doSubmit();
        },
        addUser: function (user) {
            var row = new UserRow({model: user});
            this.$('ul').prepend(row.el);
        },
        doSubmit: function () {
            var val = this.$('#new-user').val();
            var user = new User();
            user.save({content: val}, {
                success: this.addUser
            });
        },
        render: function () {
            $(this.el).html(this.template);
            this.users.each(this.addUser);
        }
    });

    var App = Backbone.Router.extend({
        routes: {
            '*actions': 'main'
        },
        initialize: function () {
        },
        main: function () {
            this.view = new UserView;
        }
    });

    this.User = User;
    this.Users = Users;
    this.UserRow = UserRow;
    this.UserView = UserView;

    $(function () {
        new App();
        Backbone.history.start();
    });
}());

