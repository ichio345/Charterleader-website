jQuery(".banner").slide({mainCell:".bd ul",effect:"left",autoPlay:true});
jQuery(".product-center").slide({});
jQuery(".product-recommend").slide({mainCell:".bd ul",autoPlay:true,effect:"leftMarquee",vis:6,interTime:50,trigger:"click"});
jQuery(".proclass-list>li:odd .detail").addClass('right');
jQuery(".proclass-list>li:even .detail").addClass('left');
jQuery(".ad").slide({mainCell:".bd ul",effect:"left",autoPlay:true});
jQuery(".test-center").slide({mainCell:".bd ul",autoPlay:true,effect:"leftMarquee",vis:3,interTime:50,trigger:"click"});
jQuery(".news-center").slide({titCell:".hd ul",mainCell:".bd .ulWrap",autoPage:true,effect:"left",autoPlay:true});
$(".history").slide({ titCell:".his-btn li", mainCell:".his-bd",delayTime:0 });
jQuery(".honor").slide({mainCell:".honor-bd ul",autoPlay:true,effect:"leftMarquee",vis:3,interTime:50,trigger:"click"});
                    