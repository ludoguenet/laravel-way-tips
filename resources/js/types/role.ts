export interface RolePivot {
    assigned_at: string | null;
}

export interface Role {
    id: number;
    name: string;
    pivot?: RolePivot;
}

export interface Golfer {
    id: number;
    name: string;
    email: string;
    roles: Role[];
}
