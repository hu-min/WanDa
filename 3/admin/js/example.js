void function () {
  'use strict';
/**
  horsey(hy, {
    suggestions: ['banana', 'apple', 'orange','zhangsan','zhangsi','zhangwu','zhangliu','zhangqi','zhangba','zhangjiu','zhangshi']
  });

  horsey(ly, {
    suggestions: function (done) {
      var start = new Date();
      lyr.innerText = 'Loading...';
      setTimeout(function () {
        lyr.innerText = 'Loaded in ' + (new Date() -	 start) + 'ms!';
        done(['banana', 'apple', 'orange']);
      }, 2000);
    }
  });
**/
  horsey(fenpeiid, {
    suggestions: [
      { value: 'wangshifan', text: 'Name：王世藩      Position：渠道经理' },
      { value: 'liangxin', text: 'Name：梁鑫      Position：技术员' },
      { value: 'mengjinhui', text: 'Name：蒙锦慧      Position：客服' },
      { value: 'linchan', text: 'Name：林婵     Position：业务员' },
      { value: 'fuzhiming', text: 'Name：符之明     Position：技术员' },
      { value: 'wangzhiwei', text: 'Name：王志伟     Position：总经理' },
      { value: 'kelihua', text: 'Name：柯丽华     Position：部门经理' },
      { value: 'linshuren', text: 'Name：林书任     Position：技术员' },
      { value: 'chenjincai', text: 'Name：陈进财     Position：技术员' },
      { value: 'gaoyujuan', text: 'Name：高玉娟     Position：销售文员' },
      { value: 'wangxingjie', text: 'Name：王杏杰     Position：行政总监' },
      { value: 'linrumei', text: 'Name：林汝妹     Position：商务-合同' },
      { value: 'huangcaixia', text: 'Name：黄彩霞     Position：客服' },
      { value: 'lvjun', text: 'Name：吕君     Position：部门经理' },
      { value: 'xiangaize', text: 'Name：冼盖泽     Position：技术组长' },
      { value: 'huangfuquan', text: 'Name：黄辅权     Position：业务员' },
      { value: 'caiyu', text: 'Name：蔡瑜     Position：销售总监' },
      { value: 'yejianrui', text: 'Name：叶剑睿     Position：送货员' },
      { value: 'wuxiujian', text: 'Name：吴秀娟     Position：仓管员' },
      { value: 'wangxiaona', text: 'Name：王小娜     Position：商务-采购' },
      { value: 'chenmingzhen', text: 'Name：陈明祯     Position：财务' },
      { value: 'huangchao', text: 'Name：黄超     Position：技术员' },
      { value: 'wangwenfeng', text: 'Name：王文锋     Position：技术员' },
      { value: 'wangpeng', text: 'Name：王鹏     Position：业务员' },
      { value: 'zhouridun', text: 'Name：周日敦     Position：业务员' },
      { value: 'chenxiaoqing', text: 'Name：陈小青     Position：财务' },
      { value: 'liuyunxiong', text: 'Name：刘运雄     Position：部门经理' },
      { value: 'tangnanbang', text: 'Name：唐南膀     Position：技术员' },
      { value: 'linhuaxin', text: 'Name：林华新     Position：技术员' },
      { value: 'zhouxue', text: 'Name：周雪     Position：技术员' },
      { value: 'lixu', text: 'Name：黎旭     Position：技术员' }
    ]
  });
/**
  horsey(ig, {
    suggestions: [
      { value: 'banana', text: 'Bananas from Amazon Rainforest' },
      { value: 'apple', text: 'Red apples from New Zealand' },
      { value: 'orange', text: 'Oranges from Moscow' },
      { value: 'lemon', text: 'Juicy lemons from Amalfitan Coast' }
    ],
    render: function (li, suggestion) {
      var image = '<img class="autofruit" src="img/fruits/' + suggestion.value + '.png" /> ';
      li.innerHTML = image + suggestion.text;
    }
  });
**/
  function events (el, type, fn) {
    if (el.addEventListener) {
      el.addEventListener(type, fn);
    } else if (el.attachEvent) {
      el.attachEvent('on' + type, wrap(fn));
    } else {
      el['on' + type] = wrap(fn);
    }
    function wrap (originalEvent) {
      var e = originalEvent || global.event;
      e.target = e.target || e.srcElement;
      e.preventDefault  = e.preventDefault  || function preventDefault () { e.returnValue = false; };
      e.stopPropagation = e.stopPropagation || function stopPropagation () { e.cancelBubble = true; };
      fn.call(el, e);
    }
  }
}();
