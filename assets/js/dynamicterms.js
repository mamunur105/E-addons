
jQuery( window ).on( 'elementor:init', function() {
    var customTermList = elementor.modules.controls.BaseData.extend({
        onBeforeRender: function () {
            // if (this.container && "section" === this.container.type) {
            //     var t = elementor.widgetsCache || elementor.config.widgets,
            //         n = {};
            //     this.container.children.forEach(function (o) {
            //         o.view.$childViewContainer.children("[data-widget_type]").each(function (o, i) {
            //             var a = e(i).data("widget_type"),
            //                 a = a.slice(0, a.lastIndexOf(".")),
            //                 r = !_.isUndefined(t[a]) && t[a];
            //             r && (n[r.widget_type] = r.title + " (" + r.widget_type + ")");
            //         });
            //     }),
            //         this.model.set("options", n);
            // }
        //    console.log( this.model.get("select2options") );
        },

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
            // console.log( this.control_select.val() );
            this.setValue(this.control_select.val());
        },

        onBeforeDestroy: function() {
            this.saveValue();
        }
    });

    elementor.addControlView('dynamicterms', customTermList);

});