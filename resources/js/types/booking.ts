export interface Course {
    id: number;
    name: string;
    city: string;
    holes: number;
}

export interface TeeTime {
    id: number;
    course_id: number;
    starts_at: string;
    capacity: number;
    course?: Course;
    bookings_count?: number;
}

export interface Golfer {
    id: number;
    name: string;
    email: string;
}

export interface Booking {
    id: number;
    golfer_id: number;
    tee_time_id: number;
    players: number;
    cancelled_at: string | null;
    tee_time?: TeeTime;
    golfer?: Golfer;
}
