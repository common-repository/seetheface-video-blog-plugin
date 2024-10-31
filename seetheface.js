function get_video_id(id)
{
window.opener.document.forms.post.content.value=window.opener.document.forms.post.content.value + '[seetheface id="' + id + '"]';
void(0);
close();
}

