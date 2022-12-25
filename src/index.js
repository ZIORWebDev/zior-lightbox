import lightbox2 from "lightbox2"
import "./style.scss";

jQuery(window).on("load", function() {
    jQuery("img").on("load", function() {
        var _this = this;
        // If the image is already wrapped with <a>, skip.
        if (jQuery(this).parent("a").length > 0) {
            return false;
        }
        
        if (ziorLB.allowed_classes.length > 0 && !isAllowedClasses(_this, ziorLB.allowed_classes)) {
            return false;
        }

        if (ziorLB.allowed_parent_classes.length > 0 && !isAllowedParentClasses(_this, ziorLB.allowed_parent_classes)) {
            return false;
        }

        if (ziorLB.disabled_classes.length > 0 && isDisabledClasses(_this, ziorLB.disabled_classes)) {
            return false;
        }

        if (ziorLB.disabled_classes.length > 0 && isDisabledParentClasses(_this, ziorLB.disabled_parent_classes)) {
            return false;
        }

        // If this is cloudinary URL, get the full image
        var imgTarget = this.src;
        if (this.src.includes("res.cloudinary.com")) {
            imgTarget = this.src.replace(/\/image\/upload\/(.*?)\//g, "/image/upload/");
        }
        jQuery(this).wrap(`<a href="${imgTarget}" data-lightbox="lightbox"></a>`);
    })
    .each(function() {
        if (this.complete) {
            jQuery(this).load();
        } else if(this.error) {
            jQuery(this).error();
        }
    });

    function isAllowedClasses(img, $classes) {
        var allowed = true;
        jQuery($classes).each(function(index, item) {
            if (!jQuery(img).hasClass(item)) {
                return false;
            }
        });

        return allowed;
    }

    function isAllowedParentClasses(img, $classes) {
        var allowed = true;
        jQuery($classes).each(function(index, item){
            if (!jQuery(img).parent(`.${item}`).length > 0) {
                return false;
            }
        });
        return allowed;
    }

    function isDisabledClasses(img, $classes) {
        var allowed = true;
        jQuery($classes).each(function(index, item){
            if (jQuery(img).hasClass(item)) {
                return false;
            }
        });
        return allowed;
    }

    function isDisabledParentClasses(img, $classes) {
        var allowed = true;
        jQuery($classes).each(function(index, item){
            if (jQuery(img).parent(`.${item}`).length > 0) {
                return false;
            }
        });
        return allowed;
    }
});