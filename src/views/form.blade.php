文件上传
<form action="{!! url('/upload/file') !!}" enctype="multipart/form-data" method="post">
    <input name="file" type="file"/>
    <input name="topic" value="avatar" type="hidden"/>
    {!! csrf_field() !!}
    <input type="submit"/>
</form>
图片上传
<form action="{!! url('/upload/image') !!}" enctype="multipart/form-data" method="post">
    <input name="file" type="file"/>
    <input name="topic" value="avatar" type="hidden"/>
    {!! csrf_field() !!}
    <input type="submit"/>
</form>