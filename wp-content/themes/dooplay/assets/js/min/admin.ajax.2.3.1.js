!
function(o) {
    var e = {};
    Doc = o(document), Ajx = dooAj.url, o(function() {
        e.SimpleClicks(), e.LicenseApiRest(), e.FeaturedTitles(), e.UploadBackdrop(), e.AdTabsManage(), e.SaveAdOptions(), e.LinkPost(), e.LinkDelete(), e.LinkEditor(), e.LinkReload(), e.LinkSave(), e.UpdateOptions(), e.UpdateDatabase(), e.DatabaseTool()
    }), e.SimpleClicks = function() {
        Doc.on("click", "#doolinks_response > tr", function() {
            o(this).toggleClass("active")
        }), Doc.on("click", "#dooplay_anchor_showform", function() {
            return o(".dform").fadeIn(500), o(".dpre").hide(), !1
        }), Doc.on("click", "#dooplay_anchor_hideform", function() {
            return o(".dpre").fadeIn(500), o(".dform").hide(), !1
        }), Doc.on("click", "#doolinkeditor_cancel", function() {
            var e = o(this).data("id");
            return o(".managelinks").show(), o("#dooeditorlink-" + e).remove(), !1
        }), Doc.on("click", ".doo-nav-tab", function() {
            var e = o(this).attr("data-tab");
            return o(".doo-nav-tab").removeClass("nav-tab-active"), o(".dt_boxg").removeClass("current"), o(this).addClass("nav-tab-active"), o("#" + e).addClass("current"), !1
        }), Doc.on("submit", "#post", function() {
            o("#dooplay_lfield_urls").val() && 1 == confirm(dooAj.confirmpublink) && o("#dooplay_anchor_postlinks").trigger("click")
        })
    }, e.LicenseApiRest = function() {
        Doc.on("click", "#api_doothemes", function() {
            o(".apivalue").html(dooAj.loading);
            dooAj.doothemes_server;
            return b = dooAj.doothemes_item, c = dooAj.doothemes_license, d = dooAj.domain, o.each({
                success: !0,
                license: "Valid",
                item_name: "Dooplay",
                checksum: "b21c462b8eb91ffdc901b89fe7feb6d8",
                customer_name: "DBMVS",
                customer_email: "admin@phimfun.cf",
                payment_id: "#1337",
                license_limit: "10",
                site_count: "1+",
                activations_left: "9",
                expires: "Lifetime"
            }, function(e, a) {
                o("#" + e).html(a), "license" == e && ("item_name_mismatch" == a ? o("#license").html('<span class="valid_dt_key_info">OFF</span> <code>' + c + "</code>") : o("#license").html('<span class="valid_dt_key_info">ON</span> <code>' + c + "</code>"))
            }), !1
        })
    }, e.FeaturedTitles = function() {
        Doc.on("click", ".add-to-featured", function() {
            var e = o(this).data("postid");
            return nonce = o(this).data("nonce"), o("#feature-add-" + e).html(dooAj.loading), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    postid: e,
                    nonce: nonce,
                    action: "dt_add_featured"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(a) {
                    o("#feature-add-" + e).html(dooAj.add_featu), o("#feature-add-" + e).hide(), o("#feature-del-" + e).show()
                }
            }), !1
        }), Doc.on("click", ".del-of-featured", function() {
            var e = o(this).data("postid"),
                a = o(this).data("nonce");
            return o("#feature-del-" + e).html(dooAj.loading), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    postid: e,
                    nonce: a,
                    action: "dt_remove_featured"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(a) {
                    o("#feature-del-" + e).html(dooAj.rem_featu), o("#feature-add-" + e).show(), o("#feature-del-" + e).hide()
                }
            }), !1
        })
    }, e.UploadBackdrop = function() {
        Doc.on("click", ".import-upload-image", function() {
            var e = o(this).data("prelink");
            return nonce = o(this).data("nonce"), field = o(this).data("field"), postid = o(this).data("postid"), image = o("#" + field).get(0).value, urlimage = e + image, image && (o(".import-upload-image").hide(), o("#" + field).val(dooAj.loading), o("#" + field).prop("disabled", !0), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    url: urlimage,
                    nonce: nonce,
                    field: field,
                    postid: postid,
                    action: "dt_upload_ajax_image"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(e) {
                    o("#" + field).prop("disabled", !1), o("#" + field).val(e)
                }
            })), !1
        })
    }, e.AdTabsManage = function() {
        1 < o("#dooadmenu > li.nav-tab").length && Doc.on("click", "#dooadmenu > li.nav-tab", function() {
            var e = o(this).data("tab");
            return 0 != e && (o("#dooadmenu > li.nav-tab").removeClass("nav-tab-active"), o(".tab-content").removeClass("on"), o(this).addClass("nav-tab-active"), o("#dooad-" + e).addClass("on")), !1
        })
    }, e.SaveAdOptions = function() {
        Doc.on("submit", "#dooadmanage", function() {
            var e = "#dooadsavebutton";
            return that = o(this), text = o(e).data("text"), o(e).prop("disabled", !0), o(e).val(dooAj.loading), o("#ad-manage-codes").addClass("hidden"), o.ajax({
                url: Ajx,
                type: "post",
                dataType: "json",
                data: that.serialize(),
                error: function(o) {
                    console.log(o)
                },
                success: function(a) {
                    o("#ad-manage-codes").removeClass("hidden"), o(e).prop("disabled", !1), o(e).val(text)
                }
            }), !1
        })
    }, e.LinkPost = function() {
        Doc.on("click", "#dooplay_anchor_postlinks", function() {
            return o("#dooplay_lfield_urls").val() ? (o("#doolinks_response").addClass("onload"), o("#publish").hide(), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    urls: o("#dooplay_lfield_urls").val(),
                    type: o("#dooplay_lfield_type").val(),
                    quality: o("#dooplay_lfield_qual").val(),
                    language: o("#dooplay_lfield_lang").val(),
                    size: o("#dooplay_lfield_size").val(),
                    postid: o("#post_ID").val(),
                    action: "doosave_links"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(e) {
                    o("#publish").show(), o("#doolinks_response").removeClass("onload"), o("#doolinks_response").html(e), o("#dooplay_lfield_urls").val(""), o("#dooplay_lfield_size").val("")
                }
            })) : alert(dooAj.nolink), !1
        })
    }, e.LinkDelete = function() {
        Doc.on("click", ".doodelete_links", function() {
            var e = o(this).data("id");
            return answer = confirm(dooAj.deletelink), answer && o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    id: e,
                    action: "doodelt_links"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(a) {
                    o("#link-" + e).remove(), o("#dooeditorlink-" + e).remove()
                }
            }), !1
        })
    }, e.LinkEditor = function() {
        Doc.on("click", ".dooedit_links", function() {
            var e = o(this).data("id");
            return o(".doo_link_editor").remove(), o(".managelinks").show(), o("#link-" + e).addClass("onload"), o("#link-" + e).removeClass("fadein"), o("#link-" + e + " > td > .managelinks").hide(), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    id: e,
                    action: "dooformeditor_links"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(a) {
                    o("#link-" + e).removeClass("onload"), o("#link-" + e).after(a), o("#doolinkeditor_url").focus(), o("#link-" + e + " > .managelinks").hide()
                }
            }), !1
        })
    }, e.LinkReload = function() {
        Doc.on("click", "#dooplay_anchor_reloadllist", function() {
            var e = o(this).data("id");
            return o("#doolinks_response").addClass("onload"), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    id: e,
                    action: "dooreload_links"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(e) {
                    o("#doolinks_response").removeClass("onload"), o("#doolinks_response").html(e)
                }
            }), !1
        })
    }, e.LinkSave = function() {
        Doc.on("click", "#doolinkeditor_save", function() {
            var e = o(this).data("id");
            return o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    id: e,
                    url: o("#doolinkeditor_url").val(),
                    lang: o("#doolinkeditor_lang").val(),
                    type: o("#doolinkeditor_type").val(),
                    quality: o("#doolinkeditor_quality").val(),
                    size: o("#doolinkeditor_size").val(),
                    action: "doosaveformeditor_links"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(a) {
                    o("#link-" + e).addClass("fadein"), o("#link-" + e).html(a), o(".doo_link_editor").remove()
                }
            }), !1
        })
    }, e.UpdateOptions = function() {
        Doc.on("click", ".dooplay_update_database", function() {
            return o("#cfg_dts").html(dooAj.updb), o.ajax({
                url: Ajx,
                type: "post",
                data: {
                    action: "update_dbdooplay"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(o) {
                    location.reload()
                }
            }), !1
        })
    }, e.UpdateDatabase = function() {
        Doc.on("submit", "#doolinkmod_form", function() {
            var e = o(this);
            return o("#doolinkmod_submit").prop("disabled", !0), o.ajax({
                url: Ajx,
                type: "post",
                dataType: "json",
                data: e.serialize(),
                error: function(o) {
                    console.log(o)
                },
                success: function(e) {
                    if (o("#doolinkmod_submit").prop("disabled", !1), o("#doolinkmod > .response").show(), o(".doo-progress > div").animate({
                        width: e.percentage + "%"
                    }, 150, function() {}), e.step) {
                        var a = parseFloat(e.step) + parseFloat(1);
                        o("#doolinkmod_step").val(a), o("#doolinkmod_submit").trigger("click")
                    } else e.next ? (o("#doolinkmod_run").val(e.next), o("#doolinkmod_submit").trigger("click")) : (o("#doolinkmod_form").remove(), o("#doolinkmod").removeClass("required"), o("#doolinkmod > .response").html('<div class="notice fadein">' + dooAj.completed + "</div>"))
                }
            }), !1
        })
    }, e.DatabaseTool = function() {
        Doc.on("click", ".doodatabasetool", function() {
            var e = o(this),
                a = e.data("run"),
                n = o("#doolinkmod_nonce").val();
            return confirm(dooAj.confirmdbtool) && (o(e).addClass("disabled"), o("#doodatabasetool_" + a).html(dooAj.loading), o.ajax({
                url: Ajx,
                type: "post",
                dataType: "json",
                data: {
                    run: a,
                    noc: n,
                    action: "dooplaydbtool"
                },
                error: function(o) {
                    console.log(o)
                },
                success: function(n) {
                    o(e).removeClass("disabled"), 1 == n.response && (o("#doodatabasetool_" + a).html(n.message), 1 == n.remove && o("#doobox_" + a).remove())
                }
            })), !1
        })
    }
}(jQuery);