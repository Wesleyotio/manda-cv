<!DOCTYPE html>
<html lang="pt">
<body>
    <div style="background-color: #f4f4f4; padding: 20px;">
        <table style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
            
            <tr>
                <td style="padding: 20px 0;">
                    <h2>Olá, Candidato {{ $name }} !</h2>
                    <p>de telefone:{{$phone}}  .</p>
                    <p>Que se candidatou para a vaga: {{$job}}.</p>
                    <p>De nivel de escolaridade: {{$education_level}}.</p>
                    @if ($obs)
                        <p>OBS: {{$obs}}.</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>