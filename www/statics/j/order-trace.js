	_adwq.push(['_setOrder',
        TMJF("#trace_out_trade_no").html(),
        parseFloat(TMJF("#trace_need_pay_money").val()),
        TMJF("#trace_create_time").val()
    ]);

    TMJF.each(TMJF("input[id^='trace_product_data_']"), function(){
		_adwq.push(['_setItem',
			TMJF(this).attr('productId'),
			TMJF(this).attr('productName'),
			parseFloat(TMJF(this).attr('productPrice')),
			TMJF(this).attr('productAmount'),
			TMJF(this).attr('productCateId'),
			TMJF(this).attr('productCateName')
		]);
	});
    _adwq.push([ '_trackTrans' ]);