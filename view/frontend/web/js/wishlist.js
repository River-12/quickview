define(
    [
        "jquery",
    ],
    function ($) {
        $(".product-addto-links .towishlist").hover(
            function (e) {
                var dataPost=$(this).attr("data-post");
                var urlWishList="wishlist\\/index\\/add";
                var urlWistList="riverstone_quickview\\/wishlist\\/add";
                dataPost=dataPost.replace(urlWishList,urlWistList);
                urlWishList="wishlist/index/add";
                urlWistList="magetop_quickview/wishlist/add";
                dataPost=dataPost.replace(urlWishList,urlWistList);
                $(this).attr("data-post",dataPost);
            }
        );
    }
);
