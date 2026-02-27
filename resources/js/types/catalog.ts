export interface CatalogCategory {
    id: number;
    name: string;
    icon: string;
    active?: boolean;
}

export interface CatalogProduct {
    id: number;
    name: string;
    description: string;
    tag: string;
    category: string;
    rating: number;
    reviews: number;
    price: string;
    productCode: string;
    image: string;
}
