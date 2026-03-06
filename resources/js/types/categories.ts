export type CategoryFormData = {
    name: string;
    icon: string;
    sort_order: number;
};

export type CategoryFormErrors = Partial<
    Record<keyof CategoryFormData, string>
>;

export type CreateCategorySheetProps = {
    open: boolean;
    iconOptions: string[];
};

export type EditCategorySheetProps = {
    open: boolean;
    form: CategoryFormData;
    errors: CategoryFormErrors;
    processing: boolean;
    iconOptions: string[];
};

export type CategoryFormFieldsProps = {
    form: CategoryFormData;
    errors: CategoryFormErrors;
    idPrefix: string;
    iconOptions: string[];
};
