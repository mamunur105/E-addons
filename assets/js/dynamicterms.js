jQuery( window ).on( 'elementor:init', function() {
var emojioneareaItemView = elementor.modules.controls.BaseData.extend({
    onReady: function () {
		this.post_type = this.$el.find('.terms-select');
        this.control_select = this.$el.find('.terms-select');
        // this.save_input = this.$el.find('.terms-select-save-value');
		this.control_select.select2({
            ajax: {
                url: 'http://dev.local/wp-admin/admin-ajax.php?action=get_posts',
                dataType: 'json',
                processResults: function(data){
                    return {
                        results: data
                    }
                }
            }
        });

        this.control_select.on('change', () => {
            this.saveValue();
        } )
		console.log( post_type );

    },

    saveValue: function() {
        this.setValue(this.control_select.val());
    },

    onBeforeDestroy: function() {

        this.saveValue();

    }
});

elementor.addControlView('dynamicterms', emojioneareaItemView);

});