@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
                <img src="{{ asset(Storage::url(Settings::setting('site.logo'))) }}" style="height:50px" alt="central sushi">
        </a>
    </td>
</tr>
