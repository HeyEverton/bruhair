export interface IProduct {
    id?: number
    name: string
    avg_price: string
    created_at?: string
    updated_at?: string
    price_formatted?: string
}

export interface IProductItem {
    product_id: number
    name: string
    avg_price: string
    formatted_price: string
    quantity: number
}
