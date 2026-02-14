export * from './auth';
export * from './navigation';
export * from './ui';

import type { Auth } from './auth';

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
};


export interface Product {
    id: number;
    name: string;
    description: string;
    price_sale: number;
    product_code: string;
    status: string;
    discount_value: number;
    discount_type: string;
}