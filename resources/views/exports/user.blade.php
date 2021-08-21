<!DOCTYPE html>
<html>
<table border="1">
    <thead>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>User</b></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td> <b>No</b> </td>
            <td> <b>Name</b> </td>
            <td> <b>Gender</b> </td>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 ;?>
        @foreach($data as $Row)
        <tr>
            <td>{{$no}}</td>
            <td>{{$Row->full_name}}</td>
            <td>{{$Row->gender}}</td>
        </tr>
        <?php $no++;?>
        @endforeach
    </tbody>
</table>

</html>