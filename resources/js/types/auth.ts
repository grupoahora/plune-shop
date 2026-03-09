export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
    roles: Role[];
};

export type Role = {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type AuthRoleFlags = {
    is_admin: boolean;
    is_cliente: boolean;
};

export type Auth = {
    user: User;
    roles: AuthRoleFlags;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
