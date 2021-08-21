<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>
</head>
<body>
<h3>Hello Admin, Greetings!</h3>
<p>
<strong>User {{$user->display_name}} has reported about a chat, Following is his message :- </strong>{{$user->report_message}}</p>
</body>
</html>
