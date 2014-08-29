# booking-test-app


## Controllers

### Main

* home()
	Show the home of website

### Hotels 

* index()
	List Hotels (paginated)
* search( $searchParams[...])
	Search Hotels and avaliability		
* show( $id/$slug )
	Show Hotel information

## Bookings

* book( $hotel_id, $bookingParams[...])
	Starts booking (checks availibity and mark as "pending" the new booking)
* payment( $booking_id)
	when the reserve requires a payment method
* confirm ( $booking_id )
	Changes status to "confirmed" in booking
* mybookings() 
	show a list of booking (filtered by logged user)

## Users 
* register()
* rememberPassword()
* login()
* logout()
* profile()
	View and edit the users profile



## Database Schema
 
![alt tag](docs/schema.png)

View: [SQL File](docs/database_schema.sql)

## DEMO

Url : http://booking.besbello.com 



