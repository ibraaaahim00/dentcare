<?php

return [
    'book_title' => 'Book Your Appointment Online',
    'select_service' => '1. Select Dental Service',
    'select_doctor' => '2. Choose Doctor',
    'select_date_time' => '3. Choose Date & Time Slot',
    'patient_details' => '4. Patient Notes & Confirmation',
    'errors' => [
        'past_date' => 'Cannot book an appointment on a past date.',
        'max_days_exceeded' => 'You can only book appointments up to :days days in advance.',
        'day_closed' => 'The clinic is closed on this day. Please select another date.',
        'outside_hours' => 'The selected slot falls outside clinic working hours.',
        'minimum_notice' => 'Appointments must be booked at least :hours hours in advance.',
        'slot_taken' => 'This appointment slot was just booked by another patient. Please choose another slot.',
        'invalid_transition' => 'Cannot change appointment status from :from to :to.',
        'unauthorized_cancel' => 'You are not authorized to cancel this appointment.',
        'cancel_deadline_passed' => 'Appointments can only be cancelled at least :hours hours before the scheduled time.',
    ],
    'success' => [
        'booked' => 'Your appointment has been successfully booked! We look forward to seeing you.',
        'cancelled' => 'Your appointment has been cancelled successfully.',
        'updated' => 'Appointment updated successfully.',
    ],
];
