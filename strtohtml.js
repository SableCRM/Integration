function GetHtmlFromString(html_str, query)
{
    let parser = new DOMParser();
    html = parser.parseFromString(html_str, 'text/html');
    switch(query)
    {
        case query:
            switch(query.search(','))
            {
                case -1:
                    return html.querySelector(query);
                    break;
                default:
                    return html.querySelectorAll(query);
            }
            break;
        default:
            return html;
    }
}