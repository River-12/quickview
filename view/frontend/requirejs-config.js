var config = {
    map: {
        '*': {
            riverstone_fancybox: 'Riverstone_Quickview/js/jquery.fancybox',
            riverstone_config: 'Riverstone_Quickview/js/riverstone_config',
            magnificPopup: 'Riverstone_Quickview/js/jquery.magnific-popup.min',
            riverstone_tocart: 'Riverstone_Quickview/js/riverstone_tocart'
        }
    },
    shim: {
        magnificPopup: {
            deps: ['jquery']
        }
    },
    config : {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Riverstone_Quickview/js/add-to-cart-mixin': true
            }
        }
    }
};
