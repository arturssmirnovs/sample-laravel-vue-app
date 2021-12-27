<tr>
<td>
<table class="footer" align="center" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell p-0" align="center">
    <div class="container-mx-100 py-26 border-solid-top">
        {{ Illuminate\Mail\Markdown::parse($slot) }}
        <p>@lang('Click to unsubscribe') <a class="unsubscribe-link" href="{{ config('app.url')."/profile" }}">@lang('Unsubscribe')</a></p>
        <p><a href="{{ config('app.url')  }}">@lang('Visit website')</a></p>
    </div>
</td>
</tr>
</table>
</td>
</tr>
