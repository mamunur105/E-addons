jQuery( window ).on( 'elementor:init', function() {
    var customTermList = elementor.modules.controls.BaseData.extend({
        onReady: function () {
            this.control_select = this.$el.find('.terms-select');
            term_tax = this.model.get("dynamic_params").term_taxonomy;
            this.control_select.select2({
                ajax: {
                    url: 'http://dev.local/wp-admin/admin-ajax.php?action=get_terms_list&tax_name=' + term_tax,
                    dataType: 'json',
                    processResults: function(data){
                        return {
                            results: data
                        }
                    }
                }
            });
            this.control_select.parent().find("ul.select2-selection__rendered").sortable({
                containment: 'parent'
            });

            
            this.control_select.on('change', () => {
                this.saveValue();
            } )
        },

        saveValue: function() {
            console.log( this.control_select.val() );
            this.setValue(this.control_select.val());
        },

        onBeforeDestroy: function() {
            
            this.saveValue();
        }
    });

    elementor.addControlView('dynamicterms', customTermList);

});