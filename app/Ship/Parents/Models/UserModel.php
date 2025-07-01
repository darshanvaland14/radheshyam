<?php

namespace App\Ship\Parents\Models;

use Apiato\Core\Abstracts\Models\UserModel as AbstractUserModel;
use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use OwenIt\Auditing\Contracts\AttributeEncoder;
use OwenIt\Auditing\Contracts\AttributeRedactor;
use OwenIt\Auditing\Contracts\IpAddressResolver;
use OwenIt\Auditing\Contracts\UrlResolver;
use OwenIt\Auditing\Contracts\UserAgentResolver;
use OwenIt\Auditing\Contracts\UserResolver;
use OwenIt\Auditing\Exceptions\AuditableTransitionException;
use OwenIt\Auditing\Exceptions\AuditingException;
use OwenIt\Auditing\Contracts\Auditable;

class UserModel extends AbstractUserModel  implements Auditable
{

    use Notifiable;
    use SoftDeletes;
    use HashIdTrait;
    use HasRoles;
    use HasApiTokens;
    use HasResourceKeyTrait;
	  use \OwenIt\Auditing\Auditable;

    public function toAudit(): array
    {
        if (!$this->readyForAuditing()) {
            throw new AuditingException('A valid audit event has not been set');
        }

        $attributeGetter = $this->resolveAttributeGetter($this->auditEvent);

        if (!method_exists($this, $attributeGetter)) {
            throw new AuditingException(sprintf(
                'Unable to handle "%s" event, %s() method missing',
                $this->auditEvent,
                $attributeGetter
            ));
        }

        $this->resolveAuditExclusions();

        list($old, $new) = $this->$attributeGetter();

        if ($this->getAttributeModifiers()) {
            foreach ($old as $attribute => $value) {
                $old[$attribute] = $this->modifyAttributeValue($attribute, $value);
            }

            foreach ($new as $attribute => $value) {
                $new[$attribute] = $this->modifyAttributeValue($attribute, $value);
            }
        }

        $morphPrefix = Config::get('audit.user.morph_prefix', 'user');

        $tags = implode(',', $this->generateTags());
        $getTenant= Auth::user();

        $tenant_id   = 0;
        $tenant_name = null;
        if(isset($getTenant))
        {
            $tenant_id   = $getTenant['tenant_id'];
            $tenant_name = $getTenant['name'];
        }

        $user = $this->resolveUser();

        return $this->transformAudit(array_merge([
            'old_values'           => $old,
            'new_values'           => $new,
            'tenant_id'            => $tenant_id,
            'user_name'            => $tenant_name,
            'event'                => $this->auditEvent,
            'auditable_id'         => $this->getKey(),
            //'user_type'       => $this->getKey(),
            'auditable_type'       => $this->getMorphClass(),
            $morphPrefix . '_id'   => $user ? $user->getAuthIdentifier() : null,
            $morphPrefix . '_type' => $user ? $user->getMorphClass() : null,
            'tags'                 => empty($tags) ? null : $tags,
        ], $this->runResolvers()));
    }

}
