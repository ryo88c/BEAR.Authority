# BEAR.Authority

BEAR.Sunday 用認証ライブラリです。

## 使い方

認証をかけたいリソースオブジェクトのメソッドに `Ryo88c\Authority\Auth` アノテーションを指定します。
`@Auth(allow="admin")` と指定すれば `role` に `admin` が設定されてるオーディエンスのアクセスが認可されます。

## カスタマイズ

認証方法を変えたい場合は `Authorization` を参考に `AuthorizationInterface` を実装してください。
`Authorization` クラスでは OAuth 2.0 Bearer と JSON Web Token を組み合わせて使っています。

認証方法を変えたい場合は `Authentication` を参考に `AuthenticationInterface` を実装してください。
`Authentication` クラスでは [JWT の RFC（RFC7519）](https://tools.ietf.org/html/rfc7519#section-4.1) に定義されてる `AudienceInterface` を承認の対象としてます。
役割の評価以外の承認方法を実装したい場合や、オーディエンスのデータ定義を変えたい場合は `AuthenticationInterface` や `AudienceInterface` を実装してください。

尚、`Audience` や `Payload` はバリューオブジェクトの性質をもたせるため、意図的に依存性を注入せず `new` しています。 