jQuery( window ).on( 'elementor:init', function() {
var emojioneareaItemView = elementor.modules.controls.BaseData.extend({
    onReady: function () {
        this.control_select = this.$el.find('.post-select');
        // this.save_input = this.$el.find('.post-select-save-value');
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

    },

    saveValue: function() {
        // console.log( this.control_select.val() );
        this.setValue(this.control_select.val() );
    },

    onBeforeDestroy: function() {

        this.saveValue();

    }
});

elementor.addControlView('selectControl', emojioneareaItemView);

});