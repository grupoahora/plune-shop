export type CategoryFormData = {
    name: string;
    icon: string;
    sort_order: number;
};

export type CategoryFormErrors = Partial<
    Record<keyof CategoryFormData, string>
>;

export type CategorySummary = {
    id: number;
    name: string;
    icon: string;
    sort_order: number;
};

export type CreateCategorySheetProps = {
    open: boolean;
    iconOptions: string[];
};

export type EditCategorySheetProps = {
    open: boolean;
    category: CategorySummary;
    iconOptions: string[];
};

export type DeleteCategoryDialogProps = {
    open: boolean;
    category: Pick<CategorySummary, 'id' | 'name'>;
};

export type CategoryFormFieldsProps = {
    form: CategoryFormData;
    errors: CategoryFormErrors;
    idPrefix: string;
    iconOptions: string[];
};
