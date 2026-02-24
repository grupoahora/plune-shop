export interface Category {
    id: number;
    name: string;
    icon: string;
    sort_order: number;
}

export type CategoryFormData = {
    name: string;
    icon: string;
    sort_order: number;
};

export type CategoryFormErrors = Partial<Record<keyof CategoryFormData, string>>;
