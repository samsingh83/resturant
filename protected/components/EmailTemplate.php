<?php
class EmailTemplate
{
	
	public function reservationTemplate()
	{
		$htm='';
		$htm.="<h2>New Reservation: </h2>";
		$htm.="<table border=\"0\" style=\"font-family:arial;\" >
		<tr>
		<td>Name:</td>
		<td>{client_name}</td>
		</tr>
		<tr>
		<td>Phone number:</td>
		<td>{phone_number}</td>
		</tr>
		<tr>
		<td>Email address:</td>
		<td>{email_address}</td>
		</tr>
		<tr>
		<td>Number of person:</td>
		<td>{number_of_person}</td>
		</tr>
		<tr>
		<td>Reservation Date:</td>
		<td>{reservation_date}</td>
		</tr>
		<tr>
		<td>Reservation Time:</td>
		<td>{reservation_time}</td>
		</tr>
		<tr>
		<td>Message / Special Request:</td>
		<td>{message}</td>
		</tr>
		</table>";
		return $htm;
	}
	
}
/*END CLASS*/