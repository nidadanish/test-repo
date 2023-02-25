{$sess_label = "user_id_"|cat:$user_info.user_id}
{$sess = $smarty.session.{$sess_label}|default:false}
{if !$sess}
	<script type="text/javascript">
		if (typeof window['_RF_FACEBOOK_PRICELIST_ID'] != 'undefined') {ldelim}
			$.ceAjax('request', fn_url("rf_pro_marketing.fb"), {ldelim}
				method: 'POST',
				caching: false,
				hidden: true,
				data: {ldelim}
					'event': 'CompleteRegistration',
					'user_id': '{$user_info.user_id}',
				{rdelim},
				callback: function (data) {ldelim}
					data = data.data;
					if (data.status == "success") {ldelim}
						fbq('track', 'CompleteRegistration', {ldelim}{rdelim}, {ldelim}eventID: data.event_id{rdelim});
					{rdelim}
				{rdelim}
			{rdelim});
		{rdelim}
	</script>
{/if}