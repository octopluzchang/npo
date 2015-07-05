$(function() {
    var keyword = ['WTF', 'theFuck', 'EJay', 'Ding', 'Test', 'Six'];
    var $searchInput = $(".searchInput");
    var tagCount = 0;
    var del = 0;
    var isFocus = false;
    var isOpenAutoList = false;
    $searchInput.keydown(function(e) {
        var key = e.keyCode;
        if (key == 32) {
            e.preventDefault();
            newTag($searchInput.val());
            $searchInput.val("");
            isOpenAutoList = false;
            $(".dropdownTagList").hide(100);
        } else if (key == 38 || key == 40) {
            e.preventDefault();
            var text = $searchInput.val().split(' ');
            if (text[text.length - 1].length > 0) {
                var temp = text[text.length - 1];
                var i = 0;
                while (i < text.length - 1) {
                    newTag(text[i]);
                    i++;
                }
                resetAutoList();
                $searchInput.val(temp);
            }
        } else if (key == 8 && $searchInput.val() == "") {
            del++;
            if (del >= 2) {
                del = 0;
                $(".tag").last().remove();
                tagCount--;
                resizeInput();
            }
        } else {
            del = 0;
        }
    });

    function resetAutoList() {
        if(keyword.length <= 0){
            return this;
        }
        $ul = $(".dropdownTagList ul");
        $ul.html("");
        for (var i in keyword) {
            var kw = keyword[i];
            var $li = $("<li>" + kw + "</li>");
            $ul.append($li);
            $li.click(function(event) {
                isOpenAutoList = false;
                newTag($(this).text());
                $searchInput.val('');
                resizeInput();
                $(".dropdownTagList").hide(100);

            });
        }
        resizeInput();
        $(".dropdownTagList").css({
            left: $searchInput.position().left
        });
        $(".dropdownTagList").show(200);
        isOpenAutoList = true;
        return this;
    }

    function newTag(t) {
        var texts = t.split(' ');
        for (var i in texts) {
            var text = texts[i];
            if (getTagList().indexOf(text) != -1 || text == "" || text == " ") {
                continue;
            }
            $tag = $("<div class='tag' id='tag" + tagCount + "'>" + text + "<i class='fa fa-times'></i></div>");
            $searchInput.before($tag);
            tagCount++;
            resizeInput();
            $tag.find("i").click(function(event) {
                $(this).parent().remove();
                resizeInput();
            });
        }
        return this;
    }

    function clearTag() {
        tagCount = 0;
        $(".tag").each(function() {
            $(this).remove();
        });
        return this;
    }

    function getTagList() {
        var res = [];
        $(".tag").each(function() {
            res.push($(this).text());
        });
        return res;
    }

    function resizeInput() {
        var maxWidth = $searchInput.parent().width() * 0.9;
        var tagWidth = 0;
        $(".tag").each(function() {
            tagWidth += $(this).width() * 1 + 24;
        });
        var temp = 70;
        if (maxWidth - tagWidth > 70) {
            temp = maxWidth - tagWidth;
        }
        $searchInput.width(temp);
        if (temp == 70) {
            $searchInput.prop('disabled', true);
            $searchInput.prop('placeholder', '');
        } else {
            $searchInput.prop('disabled', false);
            $searchInput.prop('placeholder', 'Search');
        }
        return this;
    }
    $searchInput.focus(function() {
        $(".searchIcon").addClass('searchIconFocus');
        $(".searchBorder").addClass('searchBorderFocus');
        var tagList = getTagList();
        clearTag();
        resizeInput();
        if (!isFocus && tagList.length > 0) {
            $searchInput.val(tagList.join(' ') + ' ');
        }
        isFocus = true;
    });
    
    $searchInput.focusout(function() {
        isFocus = false;
        if (!isOpenAutoList) {
            var tags = $searchInput.val().split(' ');
            $searchInput.val("");
            for (var i in tags) {
                newTag(tags[i]);
            }
            $(".searchBorder").removeClass('searchBorderFocus');
            $(".searchIcon").removeClass('searchIconFocus');
            resizeInput();
        }
    });
});