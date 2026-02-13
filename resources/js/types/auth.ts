export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
    roles: role[];
};
export type role = {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};
export type Auth = {
    user: User;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
